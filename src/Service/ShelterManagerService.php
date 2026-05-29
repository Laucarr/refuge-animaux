<?php

namespace App\Service;

use App\Entity\User;
use App\Interface\ShelterManagerInterface;

class ShelterManagerService implements ShelterManagerInterface
{
    public function getAvailableAnimalsByUser(User $user): array
    {
        $animals = [];
        foreach ($user->getShelters() as $shelter) {
            foreach ($shelter->getAnimals() as $animal) {
                if ($animal->getStatus() === 'disponible') {
                    $animals[] = $animal;
                }
            }
        }
        return $animals;
    }

    public function getUserShelters(User $user): array
    {
        return $user->getShelters()->toArray();
    }

    public function getUserShelterIds(User $user): array
    {
        return $user->getShelters()
            ->map(fn($s) => $s->getId())
            ->toArray();
    }

    public function getAdoptionsByUser(User $user): array
    {
        $adoptions = [];
        foreach ($user->getShelters() as $shelter) {
            foreach ($shelter->getAnimals() as $animal) {
                foreach ($animal->getAdoptions() as $adoption) {
                    $adoptions[] = $adoption;
                }
            }
        }
        return $adoptions;
    }

    public function getCaretakersByUser(User $user): array
    {
        $caretakers = [];
        foreach ($user->getShelters() as $shelter) {
            foreach ($shelter->getCaretakers() as $caretaker) {
                if (!in_array($caretaker, $caretakers)) {
                    $caretakers[] = $caretaker;
                }
            }
        }
        return $caretakers;
    }

    public function getAdoptersByUser(User $user): array
    {
        $adopters = [];
        foreach ($user->getShelters() as $shelter) {
            foreach ($shelter->getAnimals() as $animal) {
                foreach ($animal->getAdoptions() as $adoption) {
                    $adopter = $adoption->getAdopter();
                    if (!in_array($adopter, $adopters)) {
                        $adopters[] = $adopter;
                    }
                }
            }
        }
        return $adopters;
    }
}