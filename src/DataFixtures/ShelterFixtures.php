<?php

namespace App\DataFixtures;

use App\Entity\Shelter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ShelterFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sheltersData = [
            [
                'name'     => 'Refuge du Lac',
                'address'  => '12 Rue des Fleurs, 75001 Paris',
                'phone'    => '01 23 45 67 89',
                'email'    => 'contact@refugedulac.fr',
                'capacity' => 50,
            ],
            [
                'name'     => 'SPA de Lyon',
                'address'  => '34 Avenue Jean Jaurès, 69007 Lyon',
                'phone'    => '04 56 78 90 12',
                'email'    => 'contact@spalyon.fr',
                'capacity' => 80,
            ],
            [
                'name'     => 'Les Griffes et Pattes',
                'address'  => '8 Boulevard Victor Hugo, 13001 Marseille',
                'phone'    => '04 91 23 45 67',
                'email'    => 'info@griffesetpattes.fr',
                'capacity' => 35,
            ],
            [
                'name'     => 'Refuge Arc-en-Ciel',
                'address'  => '56 Rue de la Paix, 31000 Toulouse',
                'phone'    => '05 61 23 45 67',
                'email'    => 'contact@arcenciel-refuge.fr',
                'capacity' => 60,
            ],
        ];

        foreach ($sheltersData as $data) {
            $shelter = new Shelter();
            $shelter->setName($data['name']);
            $shelter->setAddress($data['address']);
            $shelter->setPhone($data['phone']);
            $shelter->setEmail($data['email']);
            $shelter->setCapacity($data['capacity']);

            $manager->persist($shelter);
        }

        $manager->flush();
    }
}
