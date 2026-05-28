<?php

namespace App\Service;

use App\Entity\User;
use App\Interface\ShelterManagerInterface;

class ShelterManagerService implements ShelterManagerInterface
{
    public function getAnimalsByUser(User $user): array
    {
        $animals = [];
        foreach ($user->getShelters() as $shelter) {
            foreach ($shelter->getAnimals() as $animal) {
                $animals[] = $animal;
            }
        }
        return $animals;
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
}