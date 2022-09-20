<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('sexe', ChoiceType::class,[
                'choices' => [
                    'Homme'=>'M',
                    'Femme'=>'F'
                ]
            ])
            ->add('date_naissance')
            ->add('lieu_naissance')
            ->add('telephone')
            ->add('email', EmailType::class)
            ->add('etat_civil', ChoiceType::class,[
                'choices' => [
                    'Marié(e)' => 'marié(e)',
                    'Célibataire'=> 'célibataire',
                    'Veuf(ve)'=>'veuf(ve)'
                ]
            ])
            ->add('username')
            ->add('password')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('role')
            ->add('Ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
