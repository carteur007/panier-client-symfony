<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

#[Route('/product', name: 'app_product_')]
class ProductController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack
    ) {
    }
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }
    #[Route('/show_cat/{id}/{page}', name: 'show_cat', methods: ['POST', 'GET'])]
    public function showByCategory(Request $request, Environment $twig, ProductRepository $productRepository, Category $category, int $page): Response
    {
        $offset = max(0, $request->query->getInt('page', 0));

        $paginator = $productRepository->findByCategory($category, page: $page);
        $nombres = $paginator->count();
        $nombrePage = \floor(1 + \fdiv($nombres, 10));
        return new Response($twig->render('product/show_cat.html.twig', [
            'category' => $category,
            'produits' => $paginator,
            'nombres' => $nombres,
            'nombrePage' => $nombrePage,
            'previous' => $offset - 12,
            'next' => min(count($paginator), $offset + 12),

        ]));
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(FileUploader $fileUploader, Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fichier = $form->get('imageName')->getData();
            if ($fichier) {
                $imageName = $fileUploader->upload($fichier);
                $product->setImageName($imageName);
            }
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{slug}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(FileUploader $fileUploader, Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fichier = $form->get('imageName')->getData();
            if ($fichier) {
                $imageName = $fileUploader->upload($fichier);
                $product->setImageName($imageName);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getSlug(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
