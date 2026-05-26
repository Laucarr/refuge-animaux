<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CaretakerController extends AbstractController
{
    #[Route('/caretaker', name: 'app_caretaker')]
    public function index(): Response
    {
        return $this->render('caretaker/index.html.twig', [
            'controller_name' => 'CaretakerController',
        ]);
    }
}
