<?php

namespace App\DataFixtures;

use App\Entity\Shelter;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ShelterFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = $this->userRepository->findOneBy(['email' => 'admin@example.com']);
        $test  = $this->userRepository->findOneBy(['email' => 'test@example.com']);
        $demo  = $this->userRepository->findOneBy(['email' => 'demo@example.com']);

        $sheltersData = [
            [
                'name'     => 'Refuge du Lac',
                'address'  => '12 Rue des Fleurs, 75001 Paris',
                'phone'    => '01 23 45 67 89',
                'email'    => 'contact@refugedulac.fr',
                'capacity' => 50,
                'owners'   => [$admin, $test],
            ],
            [
                'name'     => 'SPA de Lyon',
                'address'  => '34 Avenue Jean Jaurès, 69007 Lyon',
                'phone'    => '04 56 78 90 12',
                'email'    => 'contact@spalyon.fr',
                'capacity' => 80,
                'owners'   => [$admin],
            ],
            [
                'name'     => 'Les Griffes et Pattes',
                'address'  => '8 Boulevard Victor Hugo, 13001 Marseille',
                'phone'    => '04 91 23 45 67',
                'email'    => 'info@griffesetpattes.fr',
                'capacity' => 35,
                'owners'   => [$admin, $demo],
            ],
            [
                'name'     => 'Refuge Arc-en-Ciel',
                'address'  => '56 Rue de la Paix, 31000 Toulouse',
                'phone'    => '05 61 23 45 67',
                'email'    => 'contact@arcenciel-refuge.fr',
                'capacity' => 60,
                'owners'   => [$demo],
            ],
        ];

        foreach ($sheltersData as $data) {
            $shelter = new Shelter();
            $shelter->setName($data['name']);
            $shelter->setAddress($data['address']);
            $shelter->setPhone($data['phone']);
            $shelter->setEmail($data['email']);
            $shelter->setCapacity($data['capacity']);

            foreach ($data['owners'] as $owner) {
                $shelter->addOwner($owner);
            }

            $manager->persist($shelter);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}
