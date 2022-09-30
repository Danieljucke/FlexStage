<?php
namespace App\Form;

use App\Entity\CategorieHotel;
use App\Entity\Hotel;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HotelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_hotel')
            ->add('nombre_etoiles', RangeType::class,[
                'label'=> "Nombre d'étoiles",
                'attr'=> [
                    'min' => 1,
                    'max' => 5
                ]
            ])
            ->add('adresse')
            ->add('categorie', EntityType::class,[
                'label' => 'Catégories de chambres',
                'class' => CategorieHotel::class,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('ville',EntityType::class,[
                'class' => Ville::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hotel::class,
        ]);
    }
}