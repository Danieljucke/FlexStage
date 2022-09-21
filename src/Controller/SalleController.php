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
            'categories'=>$salleRepository->findAll()
        ]);
    }
}
