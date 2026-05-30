<?php

namespace App\EventListener;

use App\Entity\Adoption;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::prePersist, entity: Adoption::class)]
#[AsEntityListener(event: Events::preFlush, entity: Adoption::class)]
class AdoptionListener
{
    
    public function prePersist(Adoption $adoption): void
    {
        $this->updateAnimalStatus($adoption);
    }

    public function preFlush(Adoption $adoption, PreFlushEventArgs $args): void
    {
        $entityManager = $args->getObjectManager();
        $unitOfWork    = $entityManager->getUnitOfWork();

        $originalData = $unitOfWork->getOriginalEntityData($adoption);
        $newStatus    = $adoption->getStatus();

        if (empty($originalData)) {
            return;
        }

        $oldStatus = $originalData['status'];

        if ($oldStatus !== $newStatus) {
            $this->updateAnimalStatus($adoption);

            $unitOfWork->recomputeSingleEntityChangeSet(
                $entityManager->getClassMetadata($adoption->getAnimal()::class),
                $adoption->getAnimal()
            );
        }
    }

    private function updateAnimalStatus(Adoption $adoption): void
    {
        $animal = $adoption->getAnimal();

        if ($animal === null) {
            return;
        }

        $status = match($adoption->getStatus()) {
            'en attente'             => 'adoption à traité',
            'en cours'               => 'en cours d\'adoption',
            'finalisée'              => 'adopté',
            'annulée'                => 'disponible',
            default                  => $animal->getStatus()
        };

        $animal->setStatus($status);
    }
}