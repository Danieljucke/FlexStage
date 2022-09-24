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
#[Route('/privillege'), IsGranted("IS_AUTHENTICATED_FULLY")]
class PrivillegeController extends AbstractController
{
    #[Route('/privilleg', name: 'app_privillege'),IsGranted("ROLE_ADMIN")]
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
    #[Route('/supprimerPivillege/{id}', name: 'supprimer.privillege')]
    public function supprimerPrivillege(PrivillegeRepository $privillegeRepository,Privillege $privillege = null): Response
    {

        if ($privillege) {
            $privillegeRepository->remove($privillege, true);
            $this->addFlash('success', 'Suppression Réussi !');
        }
        else
        {
            $this->addFlash('error',"Opération Echoué !");
        }
        return $this->redirectToRoute('app_privillege');
    }
    #[Route('/montrerPrivilleg/{id}', name: 'montrer.privillege')]
    public function montrer(Privillege $privillege=null): Response
    {
        return $this->render('privillege/detailPrivillege.html.twig', [
            'privillege' => $privillege,
        ]);
        return new Response('bonjour');
    }
}
