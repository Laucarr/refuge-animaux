<?php

namespace App\DataFixtures;

use App\Entity\Species;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SpeciesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $speciesData = [
            [
                'name' => 'Chien',
                'description' => 'Animal domestique fidèle et sociable, le chien est l\'un des compagnons les plus populaires. Il existe des centaines de races aux caractères très variés.',
            ],
            [
                'name' => 'Chat',
                'description' => 'Animal indépendant et affectueux, le chat est le compagnon idéal pour les personnes recherchant un animal calme et autonome.',
            ],
            [
                'name' => 'Lapin',
                'description' => 'Animal doux et curieux, le lapin peut vivre en intérieur ou en extérieur. Il apprécie la compagnie et les espaces pour se déplacer librement.',
            ],
            [
                'name' => 'Hamster',
                'description' => 'Petit rongeur nocturne très populaire, le hamster est facile à entretenir et convient parfaitement aux petits espaces.',
            ]
        ];

        foreach ($speciesData as $data) {
            $species = new Species();
            $species->setName($data['name']);
            $species->setDescription($data['description']);

            $manager->persist($species);
        }

        $manager->flush();
    }
}
