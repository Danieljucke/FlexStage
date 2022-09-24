<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\RegionType;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/admin'),IsGranted("IS_AUTHENTICATED_FULLY")]
class ReservationController extends AbstractController
{
    #[Route('/reservation/{page?1}/{nbre?10}', name: 'app_reservation')]
    public function index($page,$nbre,Request $request, ReservationRepository $reservationRepository): Response
    {
        $reservation = new Reservation();
        $form=$this->createForm(ReservationType::class,$reservation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $reservationRepository->add($reservation,true);// elle va persiter les elements recuperer dans le formulaire et flush dans la base
        }
        $nbReservation =$reservationRepository->count([]);
        $nbPages=ceil($nbReservation/$nbre);
        $reservation=$reservationRepository->findBy([],[],$nbre,($page-1)*$nbre);
        return $this->render('reservation/index.html.twig', [
            'formReservation' => $form->createView(),
            'reservations'=>$reservation,
            'isPaginated'=>true,
            'nbrePage'=>$nbPages,
            'page'=>$page,
            'nbre'=>$nbre
        ]);
    }
    #[Route('/montrerReservation/{id}', name: 'montrer.reservation')]
    public function montrerReservation(Reservation $reservation=null): Response
    {
        return $this->render('reservation/detailReservation.html.twig', [
            'reservation' => $reservation,
        ]);
    }
//    #[Route('/{id}/modifier', name: 'modifier.reservation', methods: ['GET', 'POST'])]
//    public function modifier(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
//    {
//        $form = $this->createForm(ReservationType::class, $reservation);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $reservationRepository->add($reservation, true);
//
//            return $this->redirectToRoute('app_reservation');
//        }
//
////        return $this->renderForm('users/edit.html.twig', [
////            'reservation' => $reservation,
////            'form' => $form,
////        ]);
//        return new Response();
//    }
    #[Route('/supprimerReservation/{id}', name: 'supprimer.Reservation')]
    public function supprimerReservaiton(Reservation $reservation=null, ReservationRepository $reservationRepository): Response
    {
        if ($reservation) {
            $reservationRepository->remove($reservation, true);
            $this->addFlash('success','Suppression Réussi !');
        }else
        {
            $this->addFlash('error','Opération Echoué !');
        }
        return $this->redirectToRoute('app_reservation');
    }
}
