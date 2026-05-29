<?php

namespace App\Controller;

use App\Entity\Adoption;
use App\Form\AdoptionType;
use App\Interface\ShelterManagerInterface;
use App\Security\Voter\AdoptionVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/adoption')]
#[IsGranted('ROLE_USER')]
final class AdoptionController extends AbstractController
{
    public function __construct(private ShelterManagerInterface $shelterManager) 
    {
    }

    #[Route(name: 'app_adoption_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('adoption/index.html.twig', [
            'shelterIds' => $this->shelterManager->getUserShelterIds($this->getUser()),
        ]);
    }

    #[Route('/new', name: 'app_adoption_new', methods: ['GET', 'POST'])]
    #[IsGranted(AdoptionVoter::CREATE)]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $adoption = new Adoption();
        $form = $this->createForm(AdoptionType::class, $adoption, [
            'animals' => $this->shelterManager->getAvailableAnimalsByUser($this->getUser()),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($adoption->getAdopter() === null) {
                $newAdopter = $form->get('newAdopter')->getData();
                if ($newAdopter->getFirstName()) {
                    $entityManager->persist($newAdopter);
                    $adoption->setAdopter($newAdopter);
                }
            }

            $entityManager->persist($adoption);
            $entityManager->flush();

            return $this->redirectToRoute('app_adoption_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('adoption/new.html.twig', [
            'adoption' => $adoption,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_adoption_show', methods: ['GET'])]
    #[IsGranted(AdoptionVoter::VIEW, subject: 'adoption')]
    public function show(Adoption $adoption): Response
    {
        return $this->render('adoption/show.html.twig', [
            'adoption' => $adoption,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_adoption_edit', methods: ['GET', 'POST'])]
    #[IsGranted(AdoptionVoter::EDIT, subject: 'adoption')]
    public function edit(Request $request, Adoption $adoption, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdoptionType::class, $adoption, [
            'animals' => $this->shelterManager->getAvailableAnimalsByUser($this->getUser()),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newAdopter = $form->get('newAdopter')->getData();

            if ($newAdopter !== null && $newAdopter->getFirstName()) {
                $entityManager->persist($newAdopter);
                $adoption->setAdopter($newAdopter);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_adoption_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('adoption/edit.html.twig', [
            'adoption' => $adoption,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_adoption_delete', methods: ['POST'])]
    #[IsGranted(AdoptionVoter::DELETE, subject: 'adoption')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Adoption $adoption, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adoption->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($adoption);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_adoption_index', [], Response::HTTP_SEE_OTHER);
    }
}
