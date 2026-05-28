<?php

namespace App\Interface;

use App\Entity\User;

interface ShelterManagerInterface
{
    public function getAnimalsByUser(User $user): array;
    public function getUserShelters(User $user): array;
    public function getUserShelterIds(User $user): array;
    public function getAdoptionsByUser(User $user): array;
    public function getCaretakersByUser(User $user): array;
}