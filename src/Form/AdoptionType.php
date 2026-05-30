<?php

namespace App\Form;

use App\Entity\Adopter;
use App\Entity\Adoption;
use App\Entity\Animal;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdoptionType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'label'    => 'Date de l\'adoption',
                'widget'   => 'single_text',
                'required' => true,
            ])
            ->add('status', ChoiceType::class, [
                'label'   => 'Statut',
                'choices' => [
                    'En attente' => 'en attente',
                    'En cours'   => 'en cours',
                    'Finalisée'  => 'finalisée',
                    'Annulée'    => 'annulée',
                ],
            ])
            ->add('notes', TextareaType::class, [
                'label' => 'Notes',
                'required' => false,
                'attr' => ['rows' => 5]
            ])
            ->add('animal', EntityType::class, [
                'class' => Animal::class,
                'choice_label' => 'name',
                'choices'      => $options['animals'],
                'required' => true,
            ])
            ->add('adopter', EntityType::class, [
                'class'        => Adopter::class,
                'choice_label' => fn(Adopter $adopter) => $adopter->getFirstName() . ' ' . $adopter->getLastName(),
                'required'     => false,
                'placeholder'  => 'Sélectionnez un adoptant existant',
                'choices'      => $options['adopters'],
            ])
            ->add('newAdopter', AdopterType::class, [
                'mapped'   => false,
                'required' => false,
                'label'    => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adoption::class,
            'animals'    => [],
            'adopters'   => [],
        ]);
    }
}
