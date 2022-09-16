<?php

namespace App\DataFixtures;

use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VilleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data_ville=[
            "Aba",
            "Aketi",
            "Ango",
            "Aru",
            "Bafwasende",
            "Bagata",
            "Bakwa-Kalonji",
            "Balamba",
            "Bambesa",
            "Banana",
            "Bandundu (Banningville)",
            "Baraka",
            "Basankusu",
            "Basoko (Basoko-Bandu)",
            "Befale",
            "Beni",
            "Bikoro",
            "Binga",
            "Boende",
            "Bokungu (Bokungo)",
            "Bolobo",
            "Bolomba",
            "Boma",
            "Bomongo",
            "Bondo",
            "Bongandanga",
            "Bosobolo",
            "Budjala",
            "Bukama (Bukama-Kibanda)",
            "Bukavu (Costermansville)",
            "Bulungu",
            "Bumba",
            "Bunia",
            "Businga (Mombombo)",
            "Buta",
            "Butembo",
            "Dekese",
            "Demba",
            "Dibaya",
            "Dibaya-Lubue (Dibaya-Lubwe)",
            "Dilolo",
            "Dilunga",
            "Dimbelenge",
            "Djugu",
            "Dungu",
            "Feshi",
            "Fizi",
            "Fungurume",
            "Gandajika (Ngandajika)",
            "Gbadolite",
            "Gemena",
            "Goma",
            "Gungu",
            "Idiofa",
            "Idjwi",
            "Ikela",
            "Ilebo (Port-Franqui)",
            "Inga",
            "Ingende",
            "Inkisi (Kisantu)",
            "Inongo",
            "Irumu",
            "Isangi",
            "Isiro (Paulis)",
            "Kabalo",
            "Kabambare",
            "Kabeya-Kamwanga (Kenankuna)",
            "Kabinda",
            "Kabongo",
            "Kahemba",
            "Kalemie (Albertville)",
            "Kalima (Kamisuku)",
            "Kambove",
            "Kamina",
            "Kamituga",
            "Kampene",
            "Kananga (Luluabourg)",
            "Kaniama",
            "Kanteba (Kateba)",
            "Kanyabayonga",
            "Kapanga",
            "Kasangulu",
            "Kasenga",
            "Kasongo",
            "Kasongo-Lunda",
            "Katako-Kombe",
            "Katanda",
            "Katwa",
            "Kayna",
            "Kazumba",
            "Kenge",
            "Kibombo",
            "Kikwit",
            "Kimpese",
            "Kindu",
            "Kinshasa (Leopoldville)",
            "Kinzau-Mvuete (Kinzau-Vuete)",
            "Kipamba (Kikondja)",
            "Kipushi",
            "Kiri",
            "Kirumba",
            "Kisangani (Stanleyville)",
            "Kitona",
            "Kituku",
            "Kole",
            "Kolwezi",
            "Kongolo",
            "Kungu",
            "Kutu",
            "Libenge",
            "Likasi (Jadotville)",
            "Lisala",
            "Lodja",
            "Lomela",
            "Lubao (Sentery)",
            "Lubefu",
            "Lubero",
            "Lubudi",
            "Lubumbashi (Elizabethville)",
            "Lubutu",
            "Luebo",
            "Luiza",
            "Lukolela",
            "Lukula",
            "Luozi",
            "Lupatapata (Luhatahata)",
            "Luputa",
            "Lusambo",
            "Lwambo (Luambo)",
            "Mahagi",
            "Malemba-Nkulu",
            "Mangai (Mangai)",
            "Mangina",
            "Mankanza",
            "Manono",
            "Masi-Manimba",
            "Masisi",
            "Matadi",
            "Mbandaka (Coquilhatville)",
            "Mbanza-Ngungu (Thysville)",
            "Mbuji-Mayi (Bakwanga)",
            "Miabi",
            "Mitwaba",
            "Moba (Baudouinville)",
            "Mobayi-Mbongo",
            "Mokambo",
            "Mongbwalu",
            "Monkoto",
            "Muanda (Moanda)",
            "Mulongo",
            "Mushie",
            "Mutshatsha",
            "Mweka",
            "Mwene-Ditu",
            "Niangara",
            "Nioki",
            "Nyunzu",
            "Oicha",
            "Opala",
            "Oshwe",
            "Poko",
            "Popokabaka",
            "Punia",
            "Pweto",
            "Rutshuru",
            "Sakania",
            "Sandoa",
            "Seke-Banza",
            "Shabunda",
            "Shinkolobwe",
            "Songololo",
            "Tshela",
            "Tshikapa",
            "Tshilenge",
            "Tshimbulu",
            "Ubundu",
            "Uvira",
            "Vivi",
            "Walikale",
            "Walungu",
            "Wamba",
            "Watsa",
            "Yahuma",
            "Yakoma",
            "Yangambi",
            "Zongo"
        ];
        for ($i=0;$i<count($data_ville);$i++ )
        {
            $villes=new Ville();
            $villes->setNomVille($data_ville[$i]);
            $villes->setCreatedAt(new \DateTimeImmutable('now'));
            $villes->setUpdatedAt(new \DateTimeImmutable('now'));
            $manager->persist($villes);
        }
        $manager->flush();
    }
}
