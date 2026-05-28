<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }
    
    public function load(ObjectManager $manager): void
    {

        $emailAddresses = [
            'admin@example.com',
            'test@example.com',
            'demo@example.com',
            'example@example.com'
        ];

        $password = '1234';

        foreach ($emailAddresses as $i => $emailAddress){

            $isAdmin = ($i == 0);
            $user = new User();
            $user->setEmail($emailAddress);
            if($isAdmin){
                $user->setRoles(['ROLE_ADMIN']);
            }

            $user->setPassword(
                $this->userPasswordHasher->hashPassword($user, $password)
            );

            $manager->persist($user);
        }

        $manager->flush();
    }
}
