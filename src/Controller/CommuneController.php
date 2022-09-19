<?php

namespace App\Controller;

use App\Entity\Commune;
use App\Form\CommuneType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommuneController extends AbstractController
{
    #[Route('/commune', name: 'app_commune')]
    public function ajouterCommune(Request $request, ManagerRegistry $doctrine): Response
    {
        $communes = new Commune();
        $form=$this->createForm(CommuneType::class,$communes);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        $form->handleRequest($request);
        $recupNomCommune=$form->get('nom_commune')->getViewData();
        $repository=$doctrine->getRepository(Commune::class);
        $checkSiCommuneExiste=$repository->findBy(['nom_commune'=>$recupNomCommune]);
        if($form->isSubmitted() &&  $form->isValid())
        {
            if ($checkSiCommuneExiste!=null)
            {
                $this->addFlash('error','cette commune existe déjà dans la base de données!');
            }
            else
            {
                $entite=$doctrine->getManager();
                $communes->setCreatedAt(new \DateTimeImmutable('now'));
                $communes->setUpdatedAt(new \DateTimeImmutable('now'));
                $entite->persist($communes);
                $entite->flush();
                $this->addFlash('success','Enregistrement réussi !');
            }
        }
        return $this->render('commune/index.html.twig', [
            'formCommune' => $form->createView(),
        ]);
    }
}
