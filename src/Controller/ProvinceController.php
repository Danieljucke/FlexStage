<?php

namespace App\Controller;

use App\Entity\Province;
use App\Form\ProvinceType;
use App\Repository\ProvinceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/province'), IsGranted("IS_AUTHENTICATED_FULLY")]
class ProvinceController extends AbstractController
{
    #[Route('/voir/{page?1}/{nbre?10}', name: 'app_province'),IsGranted("ROLE_ADMIN")]
    public function AjouterProvince($page,$nbre,Request $request, ManagerRegistry $doctrine, ProvinceRepository $provinceRepository): Response
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
        $nbProvince =$provinceRepository->count([]);
        $nbPages=ceil($nbProvince/$nbre);
        $province=$provinceRepository->findBy([],[],$nbre,($page-1)*$nbre);
        return $this->render('province/Province.html.twig', [
            'formProvince' => $form->createView(),
            'provinces'=>$province,
            'isPaginated'=>true,
            'nbrePage'=>$nbPages,
            'page'=>$page,
            'nbre'=>$nbre
        ]);
    }
    #[Route('/supprimerProvince/{id}', name: 'supprimer.province')]
    public function supprimerProvince(ProvinceRepository $provinceRepository,Province $province = null): Response
    {
        if ($province) {
            $provinceRepository->remove($province,true);
            $this->addFlash('success', 'Suppression Réussi !');
        }
        else
        {
            $this->addFlash('error',"Opération Echoué !");
        }
        return $this->redirectToRoute('app_province');
    }
    #[Route('/montrerProvince/{id}', name: 'montrer.province')]
    public function montrerProvince(Province $province=null): Response
    {
//        return $this->render('users/show.html.twig', [
//            'province' => $province,
//        ]);
        return new Response('bonjour');
    }
}
