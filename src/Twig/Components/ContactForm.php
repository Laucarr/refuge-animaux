<?php

namespace App\Twig\Components;

use App\Repository\AnimalRepository;
use App\Repository\ShelterRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class ContactForm
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public int $shelterId = 0;

    #[LiveProp(writable: true)]
    public int $animalId = 0;

    #[LiveProp(writable: true)]
    public string $subject = 'autre';

    public function __construct(private AnimalRepository $animalRepository, private ShelterRepository $shelterRepository,)
    {
    }

    public function getShelters(): array
    {
        return $this->shelterRepository->findAll();
    }

    public function getAnimals(): array
    {
        if ($this->shelterId === 0) {
            return $this->animalRepository->findAvailable();
        }

        return $this->animalRepository->findAvailableByShelter($this->shelterId);
    }

    public function getSubjects(): array
    {
        return [
            'Demande d\'adoption'       => 'adoption',
            'Demande d\'info au refuge' => 'info_refuge',
            'Autre'                     => 'autre',
        ];
    }
}