<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\HotelType;
use App\Repository\HotelRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends AbstractController
{
    #[Route('/hotel', name: 'app_hotel')]
    public function create(HotelRepository $hotelRepository, ManagerRegistry $doctrine, Request $request): Response
    {
        $hotel = new Hotel();
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        $nomHotel = $form->get('nom_hotel')->getViewData();
        $checker_Hotel = $hotelRepository->findBy(['nom_hotel'=>$nomHotel]);
        //Penser à ajouter un vérificateur d'adresse car deux hôtels peuvent avoir le même nom

        if ($form->isSubmitted() && $form->isValid()){

            if ($checker_Hotel != null ){
                $this->addFlash('error', 'Cet hôtel existe déjà dans la base');
            }
            else{
                $this->addFlash('success', 'Enregistrement réussi');
                $entiteHotel =  $doctrine->getManager();
                $entiteHotel->persist($hotel);
                $entiteHotel->flush();
            }
        }

        return $this->render('hotel/index.html.twig', [
            'formHotel' => $form-> createView(),
            'hotel'=>$hotelRepository->findAll()
        ]);
    }
}
