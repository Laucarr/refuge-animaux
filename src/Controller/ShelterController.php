<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShelterController extends AbstractController
{
    #[Route('/shelter', name: 'app_shelter')]
    public function index(): Response
    {
        return $this->render('shelter/index.html.twig', [
            'controller_name' => 'ShelterController',
        ]);
    }
}
