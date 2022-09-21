<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service')]
    public function index(ServiceRepository $serviceRepository,ManagerRegistry $doctrine, Request $request): Response
    {
        $service= new Service();
        $form=$this->createForm(ServiceType::class,$service);
        $form->handleRequest($request);
        $recupNomService=$form->get('nom_service')->getViewData();
        $checkSiNomServiceExiste=$serviceRepository->findBy(['nom_service'=>$recupNomService]);
        if($form->isSubmitted()&& $form->isValid())
        {
            if ($checkSiNomServiceExiste!=null)
            {
                $this->addFlash('error','ce service existe déjà dans la base !');
            }else
            {
                $this->addFlash('error','Enregistrement Réussi !');
                $entite=$doctrine->getManager();
                $entite->persist($service);
                $entite->flush();
            }
        }
        return $this->render('service/index.html.twig', [
            'formService' => $form->createView(),
            'service'=>$serviceRepository->findAll()
        ]);
    }
}
