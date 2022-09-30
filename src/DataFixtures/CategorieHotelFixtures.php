<?php

namespace App\DataFixtures;

use App\Entity\CategorieHotel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategorieHotelFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = [
            'ECONOMIQUE',
            'CLASSIQUE',
            'DELUXE',
            'ROYAL',
        ];

        for ($i=0; $i<count($category);$i++) {
            $category_hotel = new CategorieHotel();
            $category_hotel->setDenomination($category[$i]);
            $manager->persist($category_hotel);
        }

        $manager->flush();
    }
}
