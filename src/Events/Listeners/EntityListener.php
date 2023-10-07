<?php
namespace App\Events\Listeners;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

//#[AsEntityListener(event: Events::prePersist, entity: Events::loadClassMetadata)]
//#[AsEntityListener(event: Events::preUpdate, entity:Events::loadClassMetadata)]
class EntityListener
{

    public function __construct(
        private SluggerInterface $slugger,
    ) {
        
    }

    public function PrePersist(LifecycleEventArgs $event) {
        $entity = $event->getObject();
        /*
        if (!$entity instanceof Product) {
            return;
        }
        $entityManager = $args->getObjectManager();
        */
        $entity
            ->setCreatedAt(new DateTimeImmutable())
            ->computeSlug($this->slugger);
    }
    public function PreUpdate (LifecycleEventArgs $event) {
        $entity = $event->getObject();
        $entity
            ->setUpdatedAt(new DateTimeImmutable())
            ->computeSlug($this->slugger);
    }

}