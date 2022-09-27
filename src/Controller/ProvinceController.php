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
    public function AjouterProvince($page,$nbre,Request $request, ProvinceRepository $provinceRepository): Response
    {
        $province= new Province();
        $form=$this->createForm(ProvinceType::class,$province);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        $form->handleRequest($request);
        // je check dans la BDD si le nom que je récupère dans le formulaire existe dans la base ou pas si oui alors je pose une condition
        $checkSiprovinceExiste=$provinceRepository->findBy(['nom_province'=>$form->get('nom_province')->getViewData()]);
        if ($form->isSubmitted()&& $form->isValid())
        {
            if($checkSiprovinceExiste!=null)
            {
                $this->addFlash('error','cette province existe déjà');
            }else
            {
                $province->setUpdatedAt(new \DateTimeImmutable('now'));
                $province->setCreatedAt(new \DateTimeImmutable('now'));
                $provinceRepository->add($province, true);// la méthode add permet de persiter et de flush en même temps
                $this->addFlash('success','Enregistrement Réussi !');
            }
        }
        $nbProvince =$provinceRepository->count([]);
        return $this->render('province/Province.html.twig', [
            'formProvince' => $form->createView(),
            'provinces'=>$provinceRepository->findBy([],[],$nbre,($page-1)*$nbre),
            'isPaginated'=>true,
            'nbrePage'=>ceil($nbProvince/$nbre),
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
        return $this->render('province/detailProvince.html.twig', [
            'province' => $province,
        ]);
    }
}
