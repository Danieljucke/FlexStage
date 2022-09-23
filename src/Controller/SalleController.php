<?php

namespace App\Controller;

use App\Entity\Salle;
use App\Form\SalleType;
use App\Repository\SalleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalleController extends AbstractController
{
    #[Route('/salle', name: 'app_salle')]
    public function index(SalleRepository $salleRepository, Request $request, ManagerRegistry $doctrine): Response
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
                $entite=$doctrine->getManager();
                $salles->setUpdatedAt(new \DateTimeImmutable());
                $salles->setCreatedAt(new \DateTimeImmutable());
                $entite->persist($salles);
                $entite->flush();
            }
        }
        return $this->render('salle/index.html.twig', [
            'formSalle' => $form->createView(),
            'salles'=>$salleRepository->findAll()
        ]);
    }
//    #[Route('/{id}', name: 'montrer.salle', methods: ['GET'])]
//    public function montrer( Salle $salle): Response
//    {
////        return $this->render('users/show.html.twig', [
////            'salle' => $salle,
////        ]);
//        return new Response();
//    }
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
//    #[Route('/{id}', name: 'supprimer.salle', methods: ['POST'])]
//    public function supprimer(Request $request, Salle $salle, SalleRepository $salleRepository): Response
//    {
//        if ($this->isCsrfTokenValid('delete'.$salle->getId(), $request->request->get('_token'))) {
//            $salleRepository->remove($salle, true);
//        }
//        return $this->redirectToRoute('app_salle');
//    }
}
