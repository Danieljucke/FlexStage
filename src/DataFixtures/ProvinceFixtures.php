<?php

namespace App\DataFixtures;

use App\Entity\Province;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProvinceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data_province=[
            "BAS UELE",
            "EQUATEUR",
            "HAUT KATANGA",
            "HAUT LOMAMI",
            "HAUT UELE",
            "ITURI",
            "KASAI",
            "KASAI CENTRAL",
            "KASAI ORIENTAL",
            "KINSHASA",
            "KONGO CENTRAL",
            "KWANGO",
            "KWILU",
            "LOMAMI",
            "LUALABA",
            "MAI-NDOMBE",
            "MANIEMA",
            "MONGALA",
            "NORD-KIVU",
            "NORD-UBANGI",
            "SANKURU",
            "SUD -KIVU",
            "SUD-UBANGI",
            "TANGANYIKA",
            "TSHOPO",
            "TSHUAPA",
        ];

        for ($i=0; $i<count($data_province);$i++) {
            $province = new Province();
            $province->setNomProvince($data_province[$i]);
            $province->setCreatedAt(new \DateTimeImmutable('now'));
            $province->setUpdatedAt(new \DateTimeImmutable('now'));
            $manager->persist($province);
        }
        $manager->flush();
    }
}
