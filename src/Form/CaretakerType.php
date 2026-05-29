<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Caretaker;
use App\Entity\Shelter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CaretakerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'required' => true
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'required' => true
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true
            ])
            ->add('phone', TelType::class, [
                'label' => 'Téléphone',
                'required' => false
            ])
            ->add('workDays', ChoiceType::class, [
                'label' => 'Jours de travail',
                'choices' => [
                    'Lundi'    => 'Lundi',
                    'Mardi'    => 'Mardi',
                    'Mercredi' => 'Mercredi',
                    'Jeudi'    => 'Jeudi',
                    'Vendredi' => 'Vendredi',
                    'Samedi'   => 'Samedi',
                    'Dimanche' => 'Dimanche',
                ],
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('startTime', TimeType::class, [
                'label'    => 'Heure de début',
                'widget'   => 'single_text',
                'required' => false,
            ])
            ->add('endTime', TimeType::class, [
                'label'    => 'Heure de début',
                'widget'   => 'single_text',
                'required' => false,
            ])
            ->add('shelter', EntityType::class, [
                'class' => Shelter::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
                'choices'      => $options['shelters'],
            ])
            ->add('animals', EntityType::class, [
                'class' => Animal::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
                'choices'      => $options['animals'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Caretaker::class,
            'shelters'   => [],
            'animals'    => [],
        ]);
    }
}
