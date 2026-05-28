<?php

namespace App\Controller;

use App\Entity\Shelter;
use App\Form\ShelterType;
use App\Repository\ShelterRepository;
use App\Security\Voter\ShelterVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/shelter')]
#[IsGranted('ROLE_USER')]
final class ShelterController extends AbstractController
{
    #[Route(name: 'app_shelter_index', methods: ['GET'])]
    public function index(ShelterRepository $shelterRepository): Response
    {
        return $this->render('shelter/index.html.twig', [
            'shelters' => $shelterRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_shelter_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $shelter = new Shelter();
        $shelter->addOwner($this->getUser());
        $form = $this->createForm(ShelterType::class, $shelter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($shelter);
            $entityManager->flush();

            return $this->redirectToRoute('app_shelter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('shelter/new.html.twig', [
            'shelter' => $shelter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_shelter_show', methods: ['GET'])]
    #[IsGranted(ShelterVoter::VIEW, subject: 'shelter')]
    public function show(Shelter $shelter): Response
    {
        return $this->render('shelter/show.html.twig', [
            'shelter' => $shelter,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_shelter_edit', methods: ['GET', 'POST'])]
    #[IsGranted(ShelterVoter::EDIT, subject: 'shelter')]
    public function edit(Request $request, Shelter $shelter, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ShelterType::class, $shelter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_shelter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('shelter/edit.html.twig', [
            'shelter' => $shelter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_shelter_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    #[IsGranted(ShelterVoter::DELETE, subject: 'shelter')]
    public function delete(Request $request, Shelter $shelter, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shelter->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($shelter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_shelter_index', [], Response::HTTP_SEE_OTHER);
    }
}
