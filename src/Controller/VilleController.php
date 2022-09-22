<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\Ville;
use App\Form\VilleType;
use App\Repository\VilleRepository;
use http\Env\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VilleController extends AbstractController
{
    #[Route('/ville', name: 'app_ville')]
    public function index(\Symfony\Component\HttpFoundation\Request $request, ManagerRegistry $doctrine, VilleRepository $villeRepository): Response
    {
        $villes = new Ville();
        $form=$this->createForm(VilleType::class,$villes);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        $form->handleRequest($request);
        $nomVille =$form->get('nom_ville')->getViewData();
        $repo=$doctrine->getRepository(Ville::class);
        $findIfVilleExist=$repo->findBy(['nom_ville'=>$nomVille]);
        if ($form->isSubmitted() && $form->isValid())
        {
            if ($findIfVilleExist!=null)
            {
                $this->addFlash('error', 'cette ville est déjà ');
            }
            else
            {
                $entiteManager=$doctrine->getManager();
                $villes->setUpdatedAt(new \DateTimeImmutable());
                $villes->setCreatedAt(new \DateTimeImmutable());
                $entiteManager->persist($villes);
                $entiteManager->flush();
                $this->addFlash('success','Enregistrement réussi!');
            }
        }
        return $this->render('ville/Ville.html.twig', [
            'formVille' => $form->createView(),
            'Villes'=>$villeRepository->findAll()
        ]);
    }
    #[Route('/{id}', name: 'montrer.ville', methods: ['GET'])]
    public function montrer(Ville $ville): Response
    {
        return $this->render('users/show.html.twig', [
            'ville' => $ville,
        ]);
    }
    #[Route('/{id}/modifier', name: 'modifier.ville', methods: ['GET', 'POST'])]
    public function modifier(Request $request, Ville $ville, VilleRepository $villeRepository): Response
    {
        $form = $this->createForm(VilleType::class, $ville);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $villeRepository->add($ville, true);

            return $this->redirectToRoute('app_ville');
        }

        return $this->renderForm('users/edit.html.twig', [
            'ville' => $ville,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'supprimer.ville', methods: ['POST'])]
    public function supprimer(Request $request, Ville $ville, VilleRepository $villeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ville->getId(), $request->request->get('_token'))) {
            $villeRepository->remove($ville, true);
        }
        return $this->redirectToRoute('app_ville');
    }
}
