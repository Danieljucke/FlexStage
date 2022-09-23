<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Service;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_arriver',DateType::class,['required'=>true])
            ->add('date_fin',DateType::class, ['required'=>true])
            ->add('motif',TextareaType::class, ['required'=>true])
            ->add('service',EntityType::class,[
                'required'=>true,
                'multiple'=>true,
                'class'=>Service::class
            ])
//            ->add('paiement') rajouter code de paiement de type string
            ->add('user',EntityType::class, [
                'required'=>true,
                'class'=>Users::class
            ])
            ->add('Reserver',SubmitType::class)
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}