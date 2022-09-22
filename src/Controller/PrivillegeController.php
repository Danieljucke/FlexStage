<?php

namespace App\Controller;

use App\Entity\Privillege;
use App\Form\PrivillegeType;
use App\Repository\PrivillegeRepository;
use App\Repository\ProvinceRepository;
use mysql_xdevapi\Exception;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrivillegeController extends AbstractController
{
    #[Route('/privillege', name: 'app_privillege'),IsGranted("ROLE_ADMIN")]
    public function ajouterPrivillege(Request $request, PrivillegeRepository $privillegeRepository, ManagerRegistry $doctrine): Response
    {
        $privilleges= new Privillege();
        $form=$this->createForm(PrivillegeType::class,$privilleges);
        $form->remove('statut');
        $form->remove('createdAt');
        $form->remove('updatedAt');
        $form->handleRequest($request);
        $recuperPrivillege=$form->get('privillegeName')->getViewData();
        $checkSiPrivillegeExiste=$privillegeRepository->findBy(['privillegeName'=>$recuperPrivillege]);
        if ($form->isSubmitted() && $form->isValid())
        {
            if ($checkSiPrivillegeExiste!=null)
            {
                $this->addFlash('error', 'ce privilege existe déjà dans la base de données!');
            }
            else{
                try {
                    $entite=$doctrine->getManager();
                    $privilleges->setUpdatedAt(new \DateTimeImmutable());
                    $privilleges->setCreatedAt(new \DateTimeImmutable());
                    $privilleges->setStatut('Actif');
                    $entite->persist($privilleges);
                    $entite->flush();
                }catch (Exception $exception)
                {
                    $this->addFlash('error', $exception);
                }
            }
        }
        return $this->render('privillege/index.html.twig', [
            'formPrivillege' => $form->createView(),
            'privilleges'=>$privillegeRepository->findAll()
        ]);
    }
    #[Route('/supprimerPrivillege', name:'supprimer.privillege'),IsGranted("ROLE_ADMIN")]
    public function supprimerPrivillge(ManagerRegistry $doctrine, Privillege $privillege):Response
    {
        $entite = $doctrine->getManager();
        if ($privillege) {
            $entite->remove($privillege);
            $entite->flush();
            $this->addFlash('success', 'Suppression Réussi !');
        }
        else
        {
            $this->addFlash('error',"cette province n'existe pas dans la base !");
        }
        return $this->render('privillege/index.html.twig');
    }
}
