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
    #[Route('/paiement', name: 'app_paiement'),IsGranted("ROLE_ADMIN")]
    public function index(Request $request, ManagerRegistry $doctrine,PaiementRepository $paiementRepository): Response
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
        return $this->render('paiement/index.html.twig', [
            'formPaiement' => $form->createView(),
            'paiements'=>$paiementRepository->findAll()
        ]);
    }
}
