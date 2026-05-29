<?php

namespace App\Twig\Components;

use App\Repository\AdopterRepository;
use App\Repository\AdoptionRepository;
use App\Repository\AnimalRepository;
use App\Repository\ShelterRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class AdoptionSearch
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $status = '';

    #[LiveProp(writable: true)]
    public int $adopterId = 0;

    #[LiveProp(writable: true)]
    public int $animalId = 0;

    #[LiveProp(writable: true)]
    public int $shelterId = 0;

    #[LiveProp(writable: false)]
    public array $userShelterIds = [];

    public function __construct(private AdoptionRepository $adoptionRepository, private AnimalRepository $animalRepository, private AdopterRepository $adopterRepository, private ShelterRepository $shelterRepository,)
    {
    }

    public function getAdoptions(): array
    {
        return $this->adoptionRepository->findByFilters(
            $this->status,
            $this->adopterId,
            $this->animalId,
            $this->shelterId,
            $this->userShelterIds
        );
    }

    public function getAnimals(): array
    {
        return $this->animalRepository->findBy(['shelter' => $this->userShelterIds]);
    }

    public function getAdopters(): array
    {
        return $this->adopterRepository->findAll();
    }

    public function getShelters(): array
    {
        return $this->shelterRepository->findBy(['id' => $this->userShelterIds]);
    }
}