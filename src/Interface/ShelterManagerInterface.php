<?php

namespace App\Interface;

use App\Entity\User;

interface ShelterManagerInterface
{
    public function getAvailableAnimalsByUser(User $user): array;
    public function getUserShelters(User $user): array;
    public function getUserShelterIds(User $user): array;
    public function getCaretakersByUser(User $user): array;
    public function getAdoptersByUser(User $user): array;

}