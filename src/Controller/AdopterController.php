<?php

namespace App\Controller;

use App\Entity\Adopter;
use App\Form\AdopterType;
use App\Interface\ShelterManagerInterface;
use App\Security\Voter\AdopterVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/adopter')]
#[IsGranted('ROLE_USER')]
final class AdopterController extends AbstractController
{

    public function __construct(private ShelterManagerInterface $shelterManager)
    {
    }

    #[Route(name: 'app_adopter_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('adopter/index.html.twig', [
            'adopters' => $this->shelterManager->getAdoptersByUser($this->getUser()),
        ]);
    }

    #[Route('/{id}', name: 'app_adopter_show', methods: ['GET'])]
    #[IsGranted(AdopterVoter::VIEW, subject: 'adopter')]
    public function show(Adopter $adopter): Response
    {
        return $this->render('adopter/show.html.twig', [
            'adopter' => $adopter,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_adopter_edit', methods: ['GET', 'POST'])]
    #[IsGranted(AdopterVoter::EDIT, subject: 'adopter')]
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
    #[IsGranted(AdopterVoter::DELETE, subject: 'adopter')]
    public function delete(Request $request, Adopter $adopter, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adopter->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($adopter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_adopter_index', [], Response::HTTP_SEE_OTHER);
    }
}
