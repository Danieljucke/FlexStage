<?php

namespace App\Controller;

use App\Entity\Province;
use App\Form\ProvinceType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProvinceController extends AbstractController
{
    #[Route('/province', name: 'app_province')]
    public function AjouterProvince(Request $request, ManagerRegistry $doctrine): Response
    {
        $province= new Province();
        $form=$this->createForm(ProvinceType::class,$province);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        $form->handleRequest($request);
        $recupNomProvince=$form->get('nom_province')->getViewData();
        $repository=$doctrine->getRepository(Province::class);
        $checkSiprovinceExiste=$repository->findBy(['nom_province'=>$recupNomProvince]);
        if ($form->isSubmitted()&& $form->isValid())
        {
            if($checkSiprovinceExiste!=null)
            {
                $this->addFlash('error','cette province existe déjà');
            }else
            {
                $entite=$doctrine->getManager();
                $province->setUpdatedAt(new \DateTimeImmutable('now'));
                $province->setCreatedAt(new \DateTimeImmutable('now'));
                $entite->persist($province);
                $entite->flush();
                $this->addFlash('success','Enregistrement Réussi !');
            }
        }
        return $this->render('province/Province.html.twig', [
            'formProvince' => $form->createView(),
        ]);
    }
}
