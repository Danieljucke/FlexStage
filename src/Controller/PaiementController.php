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
#[Route('/paiement'), IsGranted("IS_AUTHENTICATED_FULLY")]
class PaiementController extends AbstractController
{
    #[Route('/voir/{page?1}/{nbre?10}', name: 'app_paiement'),IsGranted("ROLE_ADMIN")]
    public function index($page,$nbre,Request $request,PaiementRepository $paiementRepository): Response
    {
        $paiements= new Paiement();
        $form=$this->createForm(PaiementType::class,$paiements);
        $form->remove('date_paiement');
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $paiements->setDatePaiement(new \DateTimeImmutable());
            $paiementRepository->add($paiements, true); // la méthode add permet de persiter et de flush en même temps
            $this->addFlash('success', 'Opération réussi !');
        }
        $nbrPaiement=$paiementRepository->count([]);
        return $this->render('paiement/index.html.twig', [
            'formPaiement' => $form->createView(),
            'paiements'=>$paiementRepository->findBy([],[],$nbre,($page-1)*$nbre),
            'isPaginated'=>true,
            'nbrePage'=>ceil($nbrPaiement/$nbre),
            'page'=>$page,
            'nbre'=>$nbre

        ]);
    }
//    #[Route('/supprimerPaiement/{id}', name: 'supprimer.paiement')]
//    public function supprimerPaiement(PaiementRepository $paiementRepository,Paiement $paiement = null): Response
//    {
//        if ($paiement) {
//            $paiementRepository->remove($paiement,true);
//            $this->addFlash('success', 'Suppression Réussi !');
//        }
//        else
//        {
//            $this->addFlash('error',"Opération Echoué !");
//        }
//        return $this->redirectToRoute('app_paiement');
//    }
    #[Route('/montrerPaiement/{id}', name: 'montrer.paiement')]
    public function montrerPaiment(Paiement $paiement=null): Response
    {
        return $this->render('paiement/detailPaiement.html.twig', [
            'paiement' => $paiement,
        ]);
    }
}
