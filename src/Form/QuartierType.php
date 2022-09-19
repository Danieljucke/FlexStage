<?php

namespace App\Form;

use App\Entity\Commune;
use App\Entity\Province;
use App\Entity\Quartier;
use App\Entity\Region;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuartierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_quartier', TextType::class, ['required'=>true])
            ->add('region', EntityType::class, [
                'required'=>true,
                'class'=>Region::class
            ])
            ->add('province',EntityType::class, [
                'required'=>true,
                'class'=>Province::class
            ])
            ->add('ville',EntityType::class,[
                'required'=>true,
                'class'=>Ville::class
            ])
            ->add('commune',EntityType::class,[
                'required'=>true,
                'class'=>Commune::class
            ])
            ->add('Ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quartier::class,
        ]);
    }
}
