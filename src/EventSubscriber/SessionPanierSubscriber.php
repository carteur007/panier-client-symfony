<?php

namespace App\EventSubscriber;

use App\Service\PanierService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class SessionPanierSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) :
            return;
        endif;

        if ($event->getRequest()->attributes->get('_stateless', false)) :
            return;
        endif;
        $session = $event->getRequest()->getSession();
        if (!$session->isStarted()) :
            $session->start();
            return;
        endif;
        /*
        $panierbag = new AttributeBag('_session_panier');
        $panierbag->setName('panier');
        //$panierbag->initialize($panierService->getPanier());
        $session->registerBag($panierbag);
        */
        //$session->start();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 127],
        ];
    }
}
