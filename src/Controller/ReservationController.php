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
#[Route('/admin')]
class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation'),/*IsGranted("IS_AUTHENTICATED_FULLY")*/]
    public function index(Request $request, ReservationRepository $reservationRepository): Response
    {
        $reservation = new Reservation();
        $form=$this->createForm(ReservationType::class,$reservation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $reservationRepository->add($reservation,true);// elle va persiter les elements recuperer dans le formulaire et flush dans la base
        }
        return $this->render('reservation/index.html.twig', [
            'formReservation' => $form->createView(),
            'reservations'=>$reservationRepository->findAll()
        ]);
    }
    #[Route('/montrerReservation/{id}', name: 'montrer.reservation')]
    public function montrerReservation(Reservation $reservation=null): Response
    {
//        return $this->render('users/show.html.twig', [
//            'reservation' => $reservation,
//        ]);
        return new Response('bonjour');
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
