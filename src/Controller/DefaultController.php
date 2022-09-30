<?php

namespace App\Controller;

use App\Repository\PaiementRepository;
use App\Repository\ReservationRepository;
use App\Repository\UsersRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/'),IsGranted("IS_AUTHENTICATED_FULLY")]
class DefaultController extends AbstractController
{
    #[Route( name: 'app_default')]
    public function index(
        UsersRepository $usersRepository,
        ReservationRepository $reservationRepository,
        PaiementRepository $paiementRepository, ManagerRegistry $d

    ): Response
    {
        $datePaiement=$paiementRepository->findByDate();
        dd($datePaiement);
        $nbrePaiement=$paiementRepository->count([]);
        $sommePaiement=0;
        for ($i=0;$i<$nbrePaiement;$i++)
        {
             $pa=$paiementRepository->findOneBySomeField(['id'=>$i+1]);
            $sommePaiement=$sommePaiement+ $pa->getMontant();
        }
        return $this->render('default/index.html.twig', [
            'nbreUtilisateur' => $usersRepository->count([]),
            'nbreReservation'=>$reservationRepository->count([]),
            'nbrePaiement'=>$paiementRepository->count([]),
            'sommePaiement'=>$sommePaiement,
//            'dateprice'=$datePaiement
        ]);
    }
}
