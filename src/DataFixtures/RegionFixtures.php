<?php

namespace App\DataFixtures;

use App\Entity\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RegionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data_region=[
            "Afrique du Sud",
            "Algérie",
            "Angola",
            "Bénin",
            "Botswana",
            "Burkina Faso",
            "Burundi",
            "Cameroun",
            "Cap-Vert",
            "Comores",
            "Congo",
            "Côte d'Ivoire",
            "Djibouti",
            "Egypte",
            "Erythrée",
            "Ethiopie",
            "Gabon",
            "Gambie",
            "Ghana",
            "Guinée",
            "Guinée équatoriale",
            "Guinée-Bissau",
            "Jamahiriya arabe",
            "libyenne",
            "Kenya",
            "Lesotho",
            "Libéria",
            "Madagascar",
            "Malawi",
            "Mali",
            "Maroc",
            "Maurice",
            "Mauritanie",
            "Mozambique",
            "Namibie",
            "Niger",
            "Nigéria",
            "Ouganda",
            "République centrafricaine",
            "République démocratique du Congo",
            "République-Unie de Tanzanie",
            "Rwanda",
            "Sao Tomé-et-Principe",
            "Sénégal",
            "Seychelles",
            "Sierra Leone",
            "Somalie",
            "Soudan",
            "Swaziland",
            "Tchad",
            "Togo",
            "Tunisie",
            "Zambie",
            "Zimbabwe",
        ];
        for ($i=0;$i<count($data_region);$i++)
        {
            $region = new Region();
            $region->setNomRegion($data_region[$i]);
            $region->setCreatedAt(new \DateTimeImmutable('now'));
            $region->setUpdatedAt(new \DateTimeImmutable('now'));
            $manager->persist($region);
        }
        $manager->flush();
    }
}
