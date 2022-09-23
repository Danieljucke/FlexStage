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

class ProvinceController extends AbstractController
{
    #[Route('/province', name: 'app_province'),IsGranted("ROLE_ADMIN")]
    public function AjouterProvince(Request $request, ManagerRegistry $doctrine, ProvinceRepository $provinceRepository): Response
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
            'provinces'=>$provinceRepository->findAll()
        ]);
    }
//    #[Route('/{id}', name: 'montrer.province', methods: ['GET'])]
//    public function montrer(Province $province): Response
//    {
////        return $this->render('users/show.html.twig', [
////            'province' => $province,
////        ]);
//        return new Response();
//    }
//    #[Route('/modifier/{id}', name: 'modifier.province', methods: ['GET', 'POST'])]
//    public function modifier(Request $request,Province $province, ProvinceRepository $provinceRepository): Response
//    {
//        $form = $this->createForm(  ProvinceType::class, $province);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $provinceRepository->add($province, true);
//
//            return $this->redirectToRoute('app_province');
//        }
//
////        return $this->renderForm('users/edit.html.twig', [
////            'province' => $province,
////            'form' => $form,
////        ]);
//        return new Response();
//    }
//    #[Route('/{id}', name: 'supprimer.province', methods: ['POST'])]
//    public function supprimer(Request $request, Province $province, ProvinceRepository $provinceRepository): Response
//    {
//        if ($this->isCsrfTokenValid('delete'.$province->getId(), $request->request->get('_token'))) {
//            $provinceRepository->remove($province, true);
//        }
//        return $this->redirectToRoute('app_province');
//    }
}
