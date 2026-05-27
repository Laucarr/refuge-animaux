<?php

namespace App\Controller;

use App\Entity\Caretaker;
use App\Form\CaretakerType;
use App\Repository\CaretakerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/caretaker')]
final class CaretakerController extends AbstractController
{
    #[Route(name: 'app_caretaker_index', methods: ['GET'])]
    public function index(CaretakerRepository $caretakerRepository): Response
    {
        return $this->render('caretaker/index.html.twig', [
            'caretakers' => $caretakerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_caretaker_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $caretaker = new Caretaker();
        $form = $this->createForm(CaretakerType::class, $caretaker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($caretaker);
            $entityManager->flush();

            return $this->redirectToRoute('app_caretaker_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('caretaker/new.html.twig', [
            'caretaker' => $caretaker,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_caretaker_show', methods: ['GET'])]
    public function show(Caretaker $caretaker): Response
    {
        return $this->render('caretaker/show.html.twig', [
            'caretaker' => $caretaker,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_caretaker_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Caretaker $caretaker, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CaretakerType::class, $caretaker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_caretaker_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('caretaker/edit.html.twig', [
            'caretaker' => $caretaker,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_caretaker_delete', methods: ['POST'])]
    public function delete(Request $request, Caretaker $caretaker, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$caretaker->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($caretaker);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_caretaker_index', [], Response::HTTP_SEE_OTHER);
    }
}
