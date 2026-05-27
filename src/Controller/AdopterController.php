<?php

namespace App\Controller;

use App\Entity\Adopter;
use App\Form\AdopterType;
use App\Repository\AdopterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/adopter')]
final class AdopterController extends AbstractController
{
    #[Route(name: 'app_adopter_index', methods: ['GET'])]
    public function index(AdopterRepository $adopterRepository): Response
    {
        return $this->render('adopter/index.html.twig', [
            'adopters' => $adopterRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_adopter_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $adopter = new Adopter();
        $form = $this->createForm(AdopterType::class, $adopter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($adopter);
            $entityManager->flush();

            return $this->redirectToRoute('app_adopter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('adopter/new.html.twig', [
            'adopter' => $adopter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_adopter_show', methods: ['GET'])]
    public function show(Adopter $adopter): Response
    {
        return $this->render('adopter/show.html.twig', [
            'adopter' => $adopter,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_adopter_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Adopter $adopter, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdopterType::class, $adopter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_adopter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('adopter/edit.html.twig', [
            'adopter' => $adopter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_adopter_delete', methods: ['POST'])]
    public function delete(Request $request, Adopter $adopter, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adopter->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($adopter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_adopter_index', [], Response::HTTP_SEE_OTHER);
    }
}
