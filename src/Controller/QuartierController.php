<?php

namespace App\Controller;

use App\Entity\Quartier;
use App\Form\QuartierType;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuartierController extends AbstractController
{
    #[Route('/quartier', name: 'app_quartier')]
    public function ajouterQuartier(ManagerRegistry $doctrine, Request $request): Response
    {
        $quartiers = new Quartier();
        $form = $this->createForm(QuartierType::class, $quartiers);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        $form->handleRequest($request);
        $recupNomQuartier = $form->get('nom_quartier')->getViewData();
        $repository = $doctrine->getRepository(Quartier::class);
        $checkSiQuartierExiste = $repository->findBy(['nom_quartier' => $recupNomQuartier]);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($checkSiQuartierExiste != null) {
                $this->addFlash('error', 'ce quartier est déjà dans la base de données !');
            } else {
                $entite = $doctrine->getManager();
                $quartiers->setCreatedAt(new \DateTimeImmutable('now'));
                $quartiers->setUpdatedAt(new \DateTimeImmutable('now'));
                $entite->persist($quartiers);
                $entite->flush();
                $this->addFlash('error', 'Enregistrement Réussi !');
            }
        }
        return $this->render('quartier/Quartier.html.twig', [
            'formQuartier' => $form->createView(),
        ]);
    }

    #[Route('/supprimerQuartier', name: 'supprimer.quartier')]
    public function supprimerQuartier(ManagerRegistry $doctrine, Quartier $quartier = null): Response
    {
        $entite = $doctrine->getManager();
        if ($quartier) {
            $entite->remove($quartier);
            $entite->flush();
            $this->addFlash('success', 'Suppression Réussi !');
        }
        else
        {
            $this->addFlash('error',"ce quartier n'existe pas dans la base !");
        }
        return new Response();
    }
}