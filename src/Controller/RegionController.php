<?php

namespace App\Controller;

use App\Entity\Region;
use App\Form\RegionType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegionController extends AbstractController
{
    #[Route('/region', name: 'app_region')]
    public function index(Request $request,ManagerRegistry $doctrine): Response
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
        return $this->render('region/region.html.twig', [
            'formRegion' => $form->createView(),
        ]);
    }
}
