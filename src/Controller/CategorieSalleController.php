<?php

namespace App\Controller;

use App\Entity\CategorieSalle;
use App\Form\CategorieSalleType;
use App\Repository\CategorieSalleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieSalleController extends AbstractController
{
    #[Route('/categorie/salle', name: 'app_categorie_salle'), IsGranted("ROLE_ADMIN")]
    public function index(Request $request, CategorieSalleRepository $categorieSalleRepository,ManagerRegistry $doctrine): Response
    {
        $categorieSalles= new CategorieSalle();
        $form=$this->createForm(CategorieSalleType::class,$categorieSalles);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        $form->handleRequest($request);
        $recupNomCategorei=$form->get('nom_categorie')->getViewData();
        $checkSiNomCategorieExiste=$categorieSalleRepository->findBy(['nom_categorie'=>$recupNomCategorei]);
        if($form->isSubmitted()&& $form->isValid())
        {
            if ($checkSiNomCategorieExiste!=null)
            {
                $this->addFlash('error','cette categorie existe déjà dans la base !');
            }else
            {
                $entite=$doctrine->getManager();
                $categorieSalles->setUpdatedAt(new \DateTimeImmutable());
                $categorieSalles->setCreatedAt(new \DateTimeImmutable());
                $entite->persist($categorieSalles);
                $entite->flush();
                $this->addFlash('success','Enregistrement Réussi !');
            }
        }
        return $this->render('categorie_salle/index.html.twig', [
            'formCategorie' => $form->createView(),
            'categories'=>$categorieSalleRepository->findAll()
        ]);
    }
//    #[Route('/{id}', name: 'montrer.category', methods: ['GET'])]
//    public function montrer(CategorieSalle $categorieSalle): Response
//    {
////        return $this->render('categorie_salle/index.html.twig', [
////            'categorieSalle' => $categorieSalle,
////        ]);
//        return new Response();
//    }
//    #[Route('/{id}/modifier', name: 'modifier.category', methods: ['GET', 'POST'])]
//    public function modifier(Request $request, CategorieSalle $categorieSalle, CategorieSalleRepository $categorieSalleRepository): Response
//    {
//        $form = $this->createForm(CategorieSalleType::class, $categorieSalle);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $categorieSalleRepository->add($categorieSalle, true);
//
//            return $this->redirectToRoute('app_categorie_salle');
//        }
//
////        return $this->renderForm('users/edit.html.twig', [
////            'categorieSalle' => $categorieSalle,
////            'form' => $form,
////        ]);
//        return  new Response();
//    }
//    #[Route('/{id}', name: 'supprimer.Category.salle', methods: ['POST'])]
//    public function supprimer(Request $request, CategorieSalle $categorieSalle, CategorieSalleRepository $categorieSalleRepository ): Response
//    {
//        if ($this->isCsrfTokenValid('delete'.$categorieSalle->getId(), $request->request->get('_token'))) {
//            $categorieSalleRepository->remove($categorieSalle, true);
//        }
//        return $this->redirectToRoute('app_categorie_salle');
//    }
}
