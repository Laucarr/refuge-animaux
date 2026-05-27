<?php

namespace App\EventListener;

use App\Entity\Adoption;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::prePersist, entity: Adoption::class)]
#[AsEntityListener(event: Events::preUpdate, entity: Adoption::class)]
class AdoptionListener
{
    public function prePersist(Adoption $adoption): void
    {
        $this->updateAnimalStatus($adoption);
    }

    public function preUpdate(Adoption $adoption): void
    {
        $this->updateAnimalStatus($adoption);
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