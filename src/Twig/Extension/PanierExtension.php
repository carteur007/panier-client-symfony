<?php

namespace App\Twig\Extension;

use App\Service\PanierService;
use App\Twig\Runtime\PanierExtensionRuntime;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class PanierExtension extends AbstractExtension
{
    private $panierservice;
    public function __construct(PanierService $panierservice)
    {
        $this->panierservice = $panierservice;
    }
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [PanierExtensionRuntime::class, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [PanierExtensionRuntime::class, 'doSomething']),
            new TwigFunction('panier', [$this, 'getPanier']),
        ];
    }
    public function getPanier(SessionInterface $session)
    {
        return $this->panierservice->getPanier($session);
    }
}
