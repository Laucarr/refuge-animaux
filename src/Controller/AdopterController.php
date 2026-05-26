<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdopterController extends AbstractController
{
    #[Route('/adopter', name: 'app_adopter')]
    public function index(): Response
    {
        return $this->render('adopter/index.html.twig', [
            'controller_name' => 'AdopterController',
        ]);
    }
}
