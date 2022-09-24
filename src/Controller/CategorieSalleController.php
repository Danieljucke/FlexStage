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
#[Route('/categorieSalle'), IsGranted("IS_AUTHENTICATED_FULLY")]
class CategorieSalleController extends AbstractController
{
    #[Route('/voir/categorie/salle', name: 'app_categorie_salle'), IsGranted("ROLE_ADMIN")]
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
    #[Route('/supprimerCategory/{id}', name: 'supprimer.category')]
    public function supprimerCategory(CategorieSalleRepository $categorieSalleRepository,CategorieSalle $categorieSalle = null): Response
    {
        if ($categorieSalle) {
           $categorieSalleRepository->remove($categorieSalle,true);
            $this->addFlash('success', 'Suppression Réussi !');
        }
        else
        {
            $this->addFlash('error',"Opération Echoué !");
        }
        return $this->redirectToRoute('app_categorie_salle');
    }
    #[Route('/montrerSalle/{id}', name: 'montrer.category')]
    public function montrerCategorieSalle(CategorieSalle $categorieSalle=null): Response
    {
//        return $this->render('users/show.html.twig', [
//            'reservation' => $reservation,
//        ]);
        return new Response('bonjour');
    }
}
