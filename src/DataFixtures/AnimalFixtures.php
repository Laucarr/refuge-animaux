<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Repository\ShelterRepository;
use App\Repository\SpeciesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AnimalFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private ShelterRepository $shelterRepository, private SpeciesRepository $speciesRepository)
    {
    }
    
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $shelters = $this->shelterRepository->findAll();
        $species  = $this->speciesRepository->findAll();

        $animalNames = [
            'Rex', 'Luna', 'Milo', 'Bella', 'Max', 'Nala', 'Oscar', 'Lola',
            'Rocky', 'Lily', 'Leo', 'Zoe', 'Simba', 'Coco', 'Thor', 'Maya',
            'Buddy', 'Nina', 'Charlie', 'Kira'
        ];

        foreach ($animalNames as $name) {
            $animal = new Animal();

            $animal->setName($name);
            $animal->setAge($faker->numberBetween(0, 15));
            $animal->setStatus('disponible');
            $animal->setDescription($faker->sentences(2, true));

            // Espèce aléatoire
            shuffle($species);
            $animal->setSpecies($species[0]);

            // Shelter aléatoire
            shuffle($shelters);
            $shelter = $shelters[0];
            $animal->setShelter($shelter);

            // Caretakers qui sont dans le shelter
            $caretakers = $shelter->getCaretakers()->toArray();
            if (!empty($caretakers)) {
                shuffle($caretakers);
                $selectedCaretakers = array_slice($caretakers, 0, rand(1, min(2, count($caretakers))));
                foreach ($selectedCaretakers as $caretaker) {
                    $animal->addCaretaker($caretaker);
                }
            }

            $manager->persist($animal);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ShelterFixtures::class,
            CaretakerFixtures::class,
            SpeciesFixtures::class,
        ];
    }
}
