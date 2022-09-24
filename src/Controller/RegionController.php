<?php

namespace App\Controller;

use App\Entity\Region;
use App\Form\RegionType;
use App\Repository\RegionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/region'),IsGranted('IS_AUTHENTICATED_FULLY')]
class RegionController extends AbstractController
{
    #[Route('/liste/{page?1}/{nbre?10}', name: 'app_region'),IsGranted("ROLE_ADMIN")]
    public function index($page,$nbre,Request $request,ManagerRegistry $doctrine, RegionRepository $regionRepository): Response
    {
        $region = new Region();
        $form=$this->createForm(RegionType::class,$region);
        $form->handleRequest($request);
        $regionNom=$form->get('nom_region')->getViewData();
        $repo=$doctrine->getRepository(Region::class);
        $findregionNom=$repo->findBy(['nom_region'=>$regionNom]);
        if ($form->isSubmitted() && $form->isValid())
        {
            if($findregionNom!=null)
            {
             $this->addFlash('error','cette region existe déjà !');
            }
            else
            {
                $region->setCreatedAt(new \DateTimeImmutable());
                $region->setUpdatedAt(new  \DateTimeImmutable());
                $entite=$doctrine->getManager();
                $entite->persist($region);
                $entite->flush();
                $this->addFlash('success','Enregistrement reussi!');
            }
        }
        $nbRegion =$regionRepository->count([]);
        $nbPages=ceil($nbRegion/$nbre);
        $region=$regionRepository->findBy([],[],$nbre,($page-1)*$nbre);
        return $this->render('region/region.html.twig', [
            'formRegion' => $form->createView(),
            'regions'=>$region,
            'isPaginated'=>true,
            'nbrePage'=>$nbPages,
            'page'=>$page,
            'nbre'=>$nbre
        ]);
    }
    #[Route('/supprimerRegion/{id}', name: 'supprimer.region')]
    public function supprimerRegion(Region $region = null,RegionRepository $regionRepository): Response
    {
        if ($region) {
            $regionRepository->remove($region, true);
            $this->addFlash('success', 'Suppression Réussi !');
        }
        else
        {
            $this->addFlash('error',"Opération Echoué !");
        }
        return $this->redirectToRoute('app_region');
    }
    #[Route('/montrerRegion/{id}', name: 'montrer.region')]
    public function montrerRegion(Region $region=null): Response
    {
//        return $this->render('users/show.html.twig', [
//            'region' => $region,
//        ]);
        return new Response('bonjour');
    }
}
