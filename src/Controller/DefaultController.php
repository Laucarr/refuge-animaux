<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use App\Repository\ShelterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AnimalRepository $animalRepository): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'animals' => $animalRepository->findAvailable(),
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(
        Request $request,
        MailerInterface $mailer,
        AnimalRepository $animalRepository,
        ShelterRepository $shelterRepository,
    ): Response {
        $defaultSubject = $request->query->get('subject', 'autre');
        $animalId       = $request->query->get('animal');
        $shelterId      = $request->query->get('shelter');

        $animal  = $animalId  ? $animalRepository->find($animalId)   : null;
        $shelter = $animal    ? $animal->getShelter()                 : ($shelterId ? $shelterRepository->find($shelterId) : null);

        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            $animal  = $data['animal']  ? $animalRepository->find($data['animal'])  : null;
            $shelter = $data['shelter'] ? $shelterRepository->find($data['shelter']) : null;

            $toEmail = $shelter
                ? $shelter->getEmail()
                : $_ENV['DEFAULT_CONTACT_EMAIL'];

            $email = (new Email())
                ->from('noreply@refuge-animaux.ch')
                ->replyTo($data['email'])
                ->to($toEmail)
                ->subject('[' . $data['subject'] . '] ' . $data['firstName'] . ' ' . $data['lastName'])
                ->html(
                    '<p><strong>De :</strong> ' . $data['firstName'] . ' ' . $data['lastName'] . '</p>' .
                    '<p><strong>Email :</strong> ' . $data['email'] . '</p>' .
                    '<p><strong>Animal :</strong> ' . ($animal ? $animal->getName() : 'Non précisé') . '</p>' .
                    '<p><strong>Message :</strong> ' . nl2br($data['message']) . '</p>'
                );

            $mailer->send($email);

            $this->addFlash('success', 'Votre message a bien été envoyé !');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('default/contact.html.twig', [
            'shelterId' => $shelter ? $shelter->getId() : 0,
            'animalId'  => $animal  ? $animal->getId()  : 0,
            'subject'   => $defaultSubject,
        ]);
    }
}
