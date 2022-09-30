<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Form\PlatType;
use App\Repository\PlatRepository;
use Symfony\Component\HttpFoundation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class PlatController extends AbstractController
{
    #[Route('/plat', name: 'app_plat')]
    public function index(): Response
    {
        return $this->render('plat/index.html.twig', [
            'controller_name' => 'PlatController',
        ]);
    }
    #[Route('/plat/ajout', name: 'ajoutPlat')]
    public function ajouter(ManagerRegistry $doctrine ,HttpFoundation\Request $request, PlatRepository $platRepository): Response

    {


        $plat = new Plat();
        $form = $this->createForm(PlatType::class, $plat);

        $form->handleRequest($request);
        $checkSiNomPlatExiste=$platRepository->findBy(['nom_plat'=>$form->get('nom_plat')->getViewData()]);
        if($form->isSubmitted()&& $form->isValid())
        {
            if ($checkSiNomPlatExiste!=null)
            {
                $this->addFlash('error','cette categorie existe déjà dans la base !');
            }else
            {
                //$restaurant->setUpdatedAt(new \DateTimeImmutable());
                //$restaurant->setCreatedAt(new \DateTimeImmutable());
                // la méthode add permet de persiter et de flush en même temps
                $platRepository->add($plat, true);
                $this->addFlash('success','Enregistrement Réussi !');
            }
        }

        return $this->render('plat/ajoutPlat.html.twig', [
            'form' => $form->createView(),
            'plat'=>$platRepository->findAll()

        ]);
    }



    #[Route('/plat/liste', name: 'listePlat')]
    public function liste(ManagerRegistry $doctrine): Response

    {
        $repository= $doctrine->getRepository(Plat::class);
        $plat= $repository->findAll();
        return $this->render('plat/listePlat.html.twig', [
            'plat' => $plat,
        ]);
    }
}
