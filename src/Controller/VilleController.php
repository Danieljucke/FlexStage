<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Form\VilleType;
use http\Env\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VilleController extends AbstractController
{
    #[Route('/ville', name: 'app_ville')]
    public function index(\Symfony\Component\HttpFoundation\Request $request, ManagerRegistry $doctrine): Response
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
        ]);
    }
}