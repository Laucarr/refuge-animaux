<?php

namespace App\DataFixtures;

use App\Entity\Adopter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AdopterFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 15; $i++) {
            $adopter = new Adopter();
            $adopter->setFirstName($faker->firstName());
            $adopter->setLastName($faker->lastName());
            $adopter->setEmail($faker->unique()->safeEmail());
            $adopter->setPhone($faker->phoneNumber());
            $adopter->setAddress($faker->address());

            $manager->persist($adopter);
        }

        $manager->flush();
    }
}
