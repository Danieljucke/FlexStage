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

class RegionController extends AbstractController
{
    #[Route('/region', name: 'app_region'),IsGranted("ROLE_ADMIN")]
    public function index(Request $request,ManagerRegistry $doctrine, RegionRepository $regionRepository): Response
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
            'regions'=>$regionRepository->findAll()
        ]);
    }

    #[Route('/{id}', name: 'montrer.region', methods: ['GET'])]
    public function montrer(Region $region): Response
    {
        return $this->render('users/show.html.twig', [
            'region' => $region,
        ]);
    }
    #[Route('/{id}/modifier', name: 'modifier.region', methods: ['GET', 'POST'])]
    public function modifier(Request $request, Region $region, RegionRepository $regionRepository): Response
    {
        $form = $this->createForm(RegionType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $regionRepository->add($region, true);

            return $this->redirectToRoute('app_regions');
        }

        return $this->renderForm('users/edit.html.twig', [
            'region' => $region,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'supprimer.region', methods: ['POST'])]
    public function supprimer(Request $request, Region $region, RegionRepository $regionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$region->getId(), $request->request->get('_token'))) {
            $regionRepository->remove($region, true);
        }
        return $this->redirectToRoute('app_region');
    }
}
