<?php

namespace App\Interface;

use App\Entity\User;

interface ShelterManagerInterface
{
    public function getAnimalsByUser(User $user): array;
    public function getAdoptionsByUser(User $user): array;
    public function getCaretakersByUser(User $user): array;
}