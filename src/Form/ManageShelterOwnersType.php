<?php

namespace App\Form;

use App\Entity\Shelter;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ManageShelterOwnersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('owners', EntityType::class, [
                'label'        => 'Gestionnaires',
                'class'        => User::class,
                'choice_label' => 'email',
                'multiple'     => true,
                'expanded'     => true, // checkboxes
                'required'     => false,
                'query_builder' => function(UserRepository $er) use ($options) {
                    return $er->createQueryBuilder('u')
                        ->where('u != :currentUser')
                        ->setParameter('currentUser', $options['current_user']);
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shelter::class,
            'current_user' => null,
        ]);
    }
}
