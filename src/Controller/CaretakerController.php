<?php

namespace App\Controller;

use App\Entity\Caretaker;
use App\Entity\Shelter;
use App\Form\CaretakerType;
use App\Interface\ShelterManagerInterface;
use App\Repository\CaretakerRepository;
use App\Security\Voter\CaretakerVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/caretaker')]
#[IsGranted('ROLE_USER')]
final class CaretakerController extends AbstractController
{
    public function __construct(private ShelterManagerInterface $shelterManager) 
    {
    }


    #[Route(name: 'app_caretaker_index', methods: ['GET'])]
    public function index(CaretakerRepository $caretakerRepository): Response
    {
        return $this->render('caretaker/index.html.twig', [
            'caretakers' => $this->shelterManager->getCaretakersByUser($this->getUser()),
        ]);
    }

    #[Route('/new', name: 'app_caretaker_new', methods: ['GET', 'POST'])]
    #[IsGranted(CaretakerVoter::CREATE)]
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
    #[IsGranted(CaretakerVoter::VIEW, subject: 'caretaker')]
    public function show(Caretaker $caretaker): Response
    {
        return $this->render('caretaker/show.html.twig', [
            'caretaker' => $caretaker,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_caretaker_edit', methods: ['GET', 'POST'])]
    #[IsGranted(CaretakerVoter::EDIT, subject: 'caretaker')]
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

    #[Route('/shelter/{id}/caretakers', name: 'api_shelter_caretakers', methods: ['GET'])]
    public function getCaretakersByShelter(Shelter $shelter): JsonResponse
    {
        $data = $shelter->getCaretakers()->map(function(Caretaker $c) {
            return [
                'id'        => $c->getId(),
                'firstName' => $c->getFirstName(),
                'lastName'  => $c->getLastName(),
            ];
        })->toArray();

        return $this->json($data);
    }

    #[Route('/{id}', name: 'app_caretaker_delete', methods: ['POST'])]
    #[IsGranted(CaretakerVoter::DELETE, subject: 'caretaker')]
    public function delete(Request $request, Caretaker $caretaker, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$caretaker->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($caretaker);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_caretaker_index', [], Response::HTTP_SEE_OTHER);
    }

}
