<?php

namespace App\Form;

use App\Entity\Paiement;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaiementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant',\Symfony\Component\Form\Extension\Core\Type\IntegerType::class,['required'=>true])
            ->add('mode_paiement',ChoiceType::class,[
                'choices' => [
            'Carte De Credit' => true,
            'Mobil Money' => true,
            'no' => false,
                    ],
                'required'=>true
            ])
            ->add('date_paiement', DateType::class
            )
            ->add('Payer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Paiement::class,
        ]);
    }
}
