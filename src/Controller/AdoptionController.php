<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdoptionController extends AbstractController
{
    #[Route('/adoption', name: 'app_adoption')]
    public function index(): Response
    {
        return $this->render('adoption/index.html.twig', [
            'controller_name' => 'AdoptionController',
        ]);
    }
}
