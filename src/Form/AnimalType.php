<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Caretaker;
use App\Entity\Shelter;
use App\Entity\Species;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'animal',
                'required' => true
            ])
            ->add('age', IntegerType::class, [
                'label' => 'Age',
                'required' => true,
                'attr'     => ['min' => 0],
                'constraints' => [
                    new PositiveOrZero(message: 'L\'âge ne peut pas être négatif.')
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => ['placeholder' => 'Décrivez l\'animal...', 'rows' => 5]
            ])
            ->add('species', EntityType::class, [
                'label' => 'Espèce',
                'class' => Species::class,
                'choice_label' => 'name',
                'required' => true,
            ])
            ->add('shelter', EntityType::class, [
                'label' => 'Refuge',
                'class' => Shelter::class,
                'choice_label' => 'name',
                'required' => true,
                'attr' => ['id' => 'animal_shelter'],
            ])
            ->add('caretaker', EntityType::class, [
                'label' => 'Soignants',
                'class' => Caretaker::class,
                'choice_label' => 'lastName',
                'multiple' => true,
                'required' => true,
                'attr' => ['id' => 'animal_caretaker'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
