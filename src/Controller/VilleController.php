<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\Ville;
use App\Form\VilleType;
use App\Repository\VilleRepository;
use http\Env\Request;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/ville'),IsGranted("IS_AUTHENTICATED_FULLY")]
class VilleController extends AbstractController
{
    #[Route('/voiretajouter/{page?1}/{nbre?10}', name: 'app_ville')]
    public function index($page,$nbre,\Symfony\Component\HttpFoundation\Request $request, ManagerRegistry $doctrine, VilleRepository $villeRepository): Response
    {
        $villes = new Ville();
        $form=$this->createForm(VilleType::class,$villes);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        $form->handleRequest($request);
        $nomVille =$form->get('nom_ville')->getViewData();
        $repo=$doctrine->getRepository(Ville::class);
        $findIfVilleExist=$repo->findBy(['nom_ville'=>$nomVille]);
        if ($form->isSubmitted() && $form->isValid())
        {
            if ($findIfVilleExist!=null)
            {
                $this->addFlash('error', 'cette ville est déjà ');
            }
            else
            {
                $entiteManager=$doctrine->getManager();
                $villes->setUpdatedAt(new \DateTimeImmutable());
                $villes->setCreatedAt(new \DateTimeImmutable());
                $entiteManager->persist($villes);
                $entiteManager->flush();
                $this->addFlash('success','Enregistrement réussi!');
            }
        }
        $nbrVille=$villeRepository->count([]);
        $nbPages=ceil($nbrVille/$nbre);
        $villes=$villeRepository->findBy([],[],$nbre,($page-1)*$nbre);
        return $this->render('ville/Ville.html.twig', [
            'formVille' => $form->createView(),
            'Villes'=>$villes,
            'isPaginated'=>true,
            'nbrePage'=>$nbPages,
            'page'=>$page,
            'nbre'=>$nbre
        ]);
    }
    #[Route('/supprimerVille/{id}', name: 'supprimer.ville')]
    public function supprimerVille(ManagerRegistry $doctrine, Ville $ville = null): Response
    {
        $entite = $doctrine->getManager();
        $form=$this->createForm(VilleType::class,$ville);
        if ($ville) {
            $entite->remove($ville);
            $entite->flush();
            $this->addFlash('success', 'Suppression Réussi !');
        }
        else
        {
            $this->addFlash('error',"cette ville n'existe pas dans la base !");
        }
        return $this->redirectToRoute('app_ville');
    }
    #[Route('/montrerVille/{id}', name: 'montrer.ville')]
    public function montrerVille(Ville $ville=null): Response
    {
//        return $this->render('users/show.html.twig', [
//            'reservation' => $ville,
//        ]);
        return new Response('bonjour');
    }
}
