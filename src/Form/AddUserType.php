<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
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
                    'Masculin'=>'M',
                    'Féminin'=>'F'
                ]
            ])
            ->add('date_naissance',DateType::class, [
                'widget'=>'choice',
                'years'=> range(date('Y')-100, date('Y')),
                'months'=> range(1,12),
                'days'=> range(1,31)
            ])
            ->add('lieu_naissance')  // A changer en EntityType avec comme entité liée la table des villes
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
            ->add('password', PasswordType::class)
            ->add('createdAt')
            ->add('updatedAt')
            ->add('role', ChoiceType::class,[
                'choices'=>[
                    'visiteur'=>1,
                    'client'=>2
                ]
            ])
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
