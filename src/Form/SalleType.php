<?php

namespace App\Form;

use App\Entity\CategorieSalle;
use App\Entity\Salle;
use App\Entity\Service;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_salle', TextType::class, ['required'=>true])
            ->add('adresse', TextareaType::class, ['required'=>true])
            ->add('ville', EntityType::class, [
                    'required'=>true,
                'attr'=>[
                    'class'=>'select2'
                ],
                'class'=>Ville::class
                ])
            ->add('statut')
            ->add('categorie', EntityType::class,[
                'required'=>true,
                'class'=>CategorieSalle::class
                ])
            ->add('service', EntityType::class,[
                'required'=>true,
                'class'=>Service::class
            ])
            ->add('Ajouter',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Salle::class,
        ]);
    }
}
