<?php

namespace App\DataFixtures;

use App\Entity\Adoption;
use App\Repository\AdopterRepository;
use App\Repository\AnimalRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AdoptionFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private AdopterRepository $adopterRepository, private AnimalRepository $animalRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $status = ['finalisée', 'en cours', 'annulée', 'en attente'];
        $animals = $this->animalRepository->findAll();
        $adopters = $this->adopterRepository->findAll();

        // Prendre 10 animaux
        shuffle($animals);
        $selectedAnimals = array_slice($animals, 0, 10);

        foreach ($selectedAnimals as $animal) {
            shuffle($status);
            shuffle($adopters);

            $adoption = new Adoption();
            $adoption->setDate($faker->dateTimeBetween('-1 year', 'now'));
            $adoption->setStatus($status[0]);
            $adoption->setNotes($faker->sentence());
            $adoption->setAnimal($animal);
            $adoption->setAdopter($adopters[0]);

            $manager->persist($adoption);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AnimalFixtures::class,
            AdopterFixtures::class,
        ];
    }
}
