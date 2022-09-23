<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\Ville;
use App\Form\VilleType;
use App\Repository\VilleRepository;
use http\Env\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VilleController extends AbstractController
{
    #[Route('/ville', name: 'app_ville')]
    public function index(\Symfony\Component\HttpFoundation\Request $request, ManagerRegistry $doctrine, VilleRepository $villeRepository): Response
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
        return $this->render('ville/Ville.html.twig', [
            'formVille' => $form->createView(),
            'Villes'=>$villeRepository->findAll()
        ]);
    }
//    #[Route('/supprimerVille', name: 'supprimer.ville')]
//    public function supprimerVille(ManagerRegistry $doctrine, Ville $ville = null): Response
//    {
//        $entite = $doctrine->getManager();
//        if ($ville) {
//            $entite->remove($ville);
//            $entite->flush();
//            $this->addFlash('success', 'Suppression Réussi !');
//        }
//        else
//        {
//            $this->addFlash('error',"cette ville n'existe pas dans la base !");
//        }
//        return new Response();
//    }
}
