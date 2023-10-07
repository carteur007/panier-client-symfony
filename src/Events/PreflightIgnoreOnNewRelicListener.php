<?php
namespace App\Events;

use Nelmio\CorsBundle\DependencyInjection\NelmioCorsExtension;
use Nelmio\CorsBundle\NelmioCorsBundle;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
class PreflightIgnoreOnNewRelicListener 
{
    public function onKernelResponse(ResponseEvent $event)
    {
        if (!extension_loaded('newrelic')) {
            return;
        }

        if ('OPTIONS' === $event->getRequest()->getMethod()) {
            newrelic_ignore_transaction();
        }
    }
}