<?php

namespace App\Twig\Components;

use App\Repository\AnimalRepository;
use App\Repository\ShelterRepository;
use App\Repository\SpeciesRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class AnimalSearch
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $status = '';

    #[LiveProp(writable: true)]
    public string $name = '';

    #[LiveProp(writable: true)]
    public int $speciesId = 0;

    #[LiveProp(writable: true)]
    public int $shelterId = 0;

    #[LiveProp(writable: false)]
    public array $userShelterIds = [];

    public function __construct(private AnimalRepository $animalRepository, private SpeciesRepository $speciesRepository, private ShelterRepository $shelterRepository)
    {
    }

    public function getAnimals(): array
    {
        return $this->animalRepository->findByFilters(
            $this->status,
            $this->name,
            $this->speciesId,
            $this->shelterId,
            $this->userShelterIds
        );
    }

    public function getSpecies(): array
    {
        return $this->speciesRepository->findAll();
    }

    public function getShelters(): array
    {
        return $this->shelterRepository->findBy(['id' => $this->userShelterIds]);
    }
}