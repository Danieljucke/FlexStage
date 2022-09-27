<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\Ville;
use App\Form\VilleType;
use App\Repository\VilleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\Translation\t;

#[Route('/ville'),IsGranted("IS_AUTHENTICATED_FULLY")]
class VilleController extends AbstractController
{
    #[Route('/voiretajouter/{page?1}/{nbre?10}', name: 'app_ville')]
    public function index($page,$nbre, Request $request, VilleRepository $villeRepository): Response
    {
        $villes = new Ville();
        $form=$this->createForm(VilleType::class,$villes);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        $form->handleRequest($request);
        // je check dans la BDD si le nom que je récupère dans le formulaire existe dans la base ou pas si oui alors je pose une condition
        $findIfVilleExist=$villeRepository->findBy(['nom_ville'=>$form->get('nom_ville')->getViewData()]);
        if ($form->isSubmitted() && $form->isValid())
        {
            if ($findIfVilleExist!=null)
            {
                $this->addFlash('error', 'cette ville est déjà ');
            }
            else
            {
                $villes->setUpdatedAt(new \DateTimeImmutable());
                $villes->setCreatedAt(new \DateTimeImmutable());
                $villeRepository->add($villes,true);// la méthode add permet de persiter et de flush en même temps
                $this->addFlash('success','Enregistrement réussi!');
            }
        }
        $nbrVille=$villeRepository->count([]);
        return $this->render('ville/Ville.html.twig', [
            'formVille' => $form->createView(),
            'Villes'=>$villeRepository->findBy([],[],$nbre,($page-1)*$nbre),
            'isPaginated'=>true,
            'nbrePage'=>ceil($nbrVille/$nbre),
            'page'=>$page,
            'nbre'=>$nbre
        ]);
    }
    #[Route('/supprimerVille/{id}', name: 'supprimer.ville')]
    public function supprimerVille(VilleRepository $villeRepository, Ville $ville = null): Response
    {
        $form=$this->createForm(VilleType::class,$ville);
        if ($ville) {
           $villeRepository->remove($ville,true);
            $this->addFlash('success', 'Suppression Réussi !');
        }
        else {$this->addFlash('error',"cette ville n'existe pas dans la base !");}
        return $this->redirectToRoute('app_ville');
    }
    #[Route('/montrerVille/{id}', name: 'montrer.ville')]
    public function montrerVille(Ville $ville=null): Response
    {
        return $this->render('ville/voirVille.html.twig', [
            'ville' => $ville,
        ]);
    }
}
