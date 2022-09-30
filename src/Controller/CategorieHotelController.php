<?php

namespace App\Controller;

use App\Entity\CategorieHotel;
use App\Form\CategorieHotelType;
use App\Repository\CategorieHotelRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route ('/category'),IsGranted("IS_AUTHENTICATED_FULLY")]
class CategorieHotelController extends AbstractController
{
    #[Route('/hotel', name: 'add_categorie_hotel'), IsGranted("ROLE_ADMIN")]
    public function index(Request $request, CategorieHotelRepository $categorieHotelRepository,ManagerRegistry $doctrine): Response
    {
        $categorieHotels= new CategorieHotel();
        $form=$this->createForm(CategorieHotelType::class,$categorieHotels);
/*        $form->remove('createdAt');
        $form->remove('updatedAt');*/
        $form->handleRequest($request);
        $recupNomCategorie=$form->get('denomination')->getViewData();
        $checkSiNomCategorieExiste=$categorieHotelRepository->findBy(['denomination'=>$recupNomCategorie]);
        if($form->isSubmitted()&& $form->isValid())
        {
            if ($checkSiNomCategorieExiste!=null)
            {
                $this->addFlash('error','cette categorie existe déjà dans la base !');
            }else
            {
                $entite=$doctrine->getManager();
/*                $categorieSalles->setUpdatedAt(new \DateTimeImmutable());
                $categorieSalles->setCreatedAt(new \DateTimeImmutable());*/
                $entite->persist($categorieHotels);
                $entite->flush();
                $this->addFlash('success','Enregistrement Réussi !');
            }
        }
        return $this->render('categorie_hotel/index.html.twig', [
            'formCategorie' => $form->createView(),
            'categories'=>$categorieHotelRepository->findAll()
        ]);
    }

}
