<?php

namespace App\DataFixtures;

use App\Entity\Caretaker;
use App\Repository\ShelterRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CaretakerFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private ShelterRepository $shelterRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        $shelters = $this->shelterRepository->findAll();

        $allDays = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

        for ($i = 0; $i < 10; $i++) {
            $caretaker = new Caretaker();
            $caretaker->setFirstName($faker->firstName());
            $caretaker->setLastName($faker->lastName());
            $caretaker->setEmail($faker->unique()->safeEmail());
            $caretaker->setPhone($faker->phoneNumber());

            // Sélectionne entre 2 et 5 jours aléatoires
            $randomDays = $faker->randomElements($allDays, $faker->numberBetween(2, 5));
            $caretaker->setWorkDays($randomDays);

            // Heure de début entre 7h et 10h
            $startTime = new \DateTime();
            $startTime->setTime($faker->numberBetween(7, 10), 0);
            $caretaker->setStartTime($startTime);

            // Heure de fin entre 16h et 19h
            $endTime = new \DateTime();
            $endTime->setTime($faker->numberBetween(16, 19), 0);
            $caretaker->setEndTime($endTime);

            // Assigne un shelter aléatoire
            shuffle($shelters);
            $caretaker->addShelter($shelters[0]);

            $manager->persist($caretaker);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ShelterFixtures::class
        ];
    }
}
