<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Form\PaiementType;
use App\Repository\PaiementRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaiementController extends AbstractController
{
    #[Route('/paiement/{page?1}/{nbre?10}', name: 'app_paiement'),IsGranted("ROLE_ADMIN")]
    public function index($page,$nbre,Request $request, ManagerRegistry $doctrine,PaiementRepository $paiementRepository): Response
    {
        $paiements= new Paiement();
        $form=$this->createForm(PaiementType::class,$paiements);
        $form->remove('date_paiement');
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entite=$doctrine->getManager();
            $paiements->setDatePaiement(new \DateTimeImmutable());
            $entite->persist($paiements);
            $entite->flush();
        }
//        $nbrPaiement=$paiementRepository->count([]);
//        $nbPages=ceil($nbrPaiement/$nbre);
//        $paiements=$paiementRepository->findBy()
        return $this->render('paiement/index.html.twig', [
            'formPaiement' => $form->createView(),
            'paiements'=>$paiements
        ]);
    }
    #[Route('/supprimerPaiement/{id}', name: 'supprimer.paiement')]
    public function supprimerPaiement(ManagerRegistry $doctrine,Paiement $paiement = null): Response
    {
        $entite = $doctrine->getManager();
        $form=$this->createForm(PaiementType::class,$paiement);
        if ($paiement) {
            $entite->remove($paiement);
            $entite->flush();
            $this->addFlash('success', 'Suppression Réussi !');
        }
        else
        {
            $this->addFlash('error',"Opération Echoué !");
        }
        return $this->redirectToRoute('app_paiement');
    }
//    #[Route('/{id}', name: 'montrer.paiement', methods: ['GET'])]
//    public function montrer(Paiement $paiement): Response
//    {
////        return $this->render('users/show.html.twig', [
////            'paiement' => $paiement,
////        ]);
//        return new Response();
//    }
}
