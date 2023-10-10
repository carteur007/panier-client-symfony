<?php
namespace App\Events\Listeners;

use App\Entity\Category;
use App\Entity\Commande;
use App\Entity\Product;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

##[AsEntityListener(event: Events::prePersist, entity:User::class)]
##[AsEntityListener(event: Events::preUpdate, entity:User::class)]
##[AsEntityListener(event: Events::prePersist, entity:Product::class)]
##[AsEntityListener(event: Events::preUpdate, entity:Product::class)]
##[AsEntityListener(event: Events::prePersist, entity:Category::class)]
##[AsEntityListener(event: Events::preUpdate, entity:Category::class)]
##[AsEntityListener(event: Events::prePersist, entity:Commande::class)]
##[AsEntityListener(event: Events::preUpdate, entity:Commande::class)]
#[AsDoctrineListener(event: Events::postPersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
class EntityListener
{

    public function __construct(
        private SluggerInterface $slugger,
    ) {
        
    }

    public function postPersist(PostPersistEventArgs $event)
    {
        $entity = $event->getObject();
        /*
        if (!$entity instanceof Product) {
            return;
        }
        $entityManager = $args->getObjectManager();
        *
        $entity
            ->setCreatedAt(new DateTimeImmutable())
            ->computeSlug($this->slugger);
        */
    }
    public function prePersist(PrePersistEventArgs $event)
    {
        $entity = $event->getObject();
        $entity
            ->setCreatedAt(new DateTimeImmutable())
            ->computeSlug($this->slugger);
    }
    public function preUpdate (PreUpdateEventArgs $event)
    {
        $entity = $event->getObject();
        $entity
            ->setUpdatedAt(new DateTimeImmutable())
            ->computeSlug($this->slugger);
    }

}