<?php

namespace App\Form;

use App\Entity\Product;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('discountPercentage')
            ->add('quantity')
            ->add('imageName', FileType::class, [
                'label' => 'Image(pnp,jpg,jpeg)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '300k',
                        'mimeTypes' => ['image/png','image/jpg','image/jpeg'],
                        'maxSizeMessage' => 'La taille du fichier ne pas depasse 300k',
                        'mimeTypesMessage' => 'SVP choisissez un dont l\'extension est dans la liste suivante.[.png,.jpeg,.jpg]',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
