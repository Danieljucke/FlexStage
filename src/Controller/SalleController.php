<?php

namespace App\Controller;

use App\Entity\Salle;
use App\Form\SalleType;
use App\Repository\SalleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/Salle'), IsGranted("IS_AUTHENTICATED_FULLY")]
class SalleController extends AbstractController
{
    #[Route('/voirEtAjouter/{page?1}/{nbre?10}', name: 'app_salle')]
    public function index($page,$nbre,SalleRepository $salleRepository, Request $request, ManagerRegistry $doctrine): Response
    {
        $salles= new Salle();
        $form=$this->createForm(SalleType::class,$salles);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        $form->handleRequest($request);
        $recupNomSalle=$form->get('nom_salle')->getViewData();
        $checkSiNomSalleExiste=$salleRepository->findBy(['nom_salle'=>$recupNomSalle]);
        if($form->isSubmitted()&& $form->isValid())
        {
            if ($checkSiNomSalleExiste!=null)
            {
                $this->addFlash('error','cette Salle existe déjà dans la base !');
            }else
            {
                $this->addFlash('success','Enregistrement Réussi !');
                $entite=$doctrine->getManager();
                $salles->setUpdatedAt(new \DateTimeImmutable());
                $salles->setCreatedAt(new \DateTimeImmutable());
                $entite->persist($salles);
                $entite->flush();
            }
        }
        $nbSalle =$salleRepository->count([]);
        $nbPages=ceil($nbSalle/$nbre);
        $salles=$salleRepository->findBy([],[],$nbre,($page-1)*$nbre);
        return $this->render('salle/index.html.twig', [
            'formSalle' => $form->createView(),
            'salles'=>$salles,
            'isPaginated'=>true,
            'nbrePage'=>$nbPages,
            'page'=>$page,
            'nbre'=>$nbre
        ]);
    }
    #[Route('/montrerSalle/{id}', name: 'montrer.salle')]
    public function montrerSalle( Salle $salle=null): Response
    {
        return $this->render('salle/detailSalle.html.twig', [
            'salle' => $salle,
        ]);
    }
//    #[Route('/{id}/modifier', name: 'modifier.salle', methods: ['GET', 'POST'])]
//    public function modifier(Request $request, Salle $salle,SalleRepository $salleRepository): Response
//    {
//        $form = $this->createForm(SalleType::class, $salle);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $salleRepository->add($salle, true);
//
//            return $this->redirectToRoute('app_salle');
//        }
//
////        return $this->renderForm('users/edit.html.twig', [
////            'salle' => $salle,
////            'form' => $form,
////        ]);
//        return new Response();
//    }
    #[Route('/supprimerSalle/{id}', name: 'supprimer.salle')]
    public function supprimerSalle( Salle $salle=null, SalleRepository $salleRepository): Response
    {
        if ($salle) {
            $salleRepository->remove($salle, true);
            $this->addFlash('success','Suppression Réussi !');
        }
        else
        {
            $this->addFlash('error','Opération Echoué !');
        }
        return $this->redirectToRoute('app_salle');
    }
}
