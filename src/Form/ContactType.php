<?php

namespace App\Form;

use App\Repository\AnimalRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function __construct(private AnimalRepository $animalRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, ['label' => 'Prénom'])
            ->add('lastName', TextType::class, ['label' => 'Nom'])
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('subject', ChoiceType::class, [
                'label'   => 'Sujet',
                'choices' => [
                    'Demande d\'adoption'       => 'adoption',
                    'Demande d\'info au refuge' => 'info_refuge',
                    'Autre'                     => 'autre',
                ],
            ])
            ->add('message', TextareaType::class, ['label' => 'Message', 'attr' => ['rows' => 5]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
