<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\RestaurantType;
use App\Repository\RestaurantRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class RestaurantController extends AbstractController
{
    #[Route('/restau/restaurant', name: 'app_restaurant')]
    public function index(): Response
    {
        return $this->render('restaurant/index.html.twig', [
            'controller_name' => 'RestaurantController',
        ]);
    }

    #[Route('/restaurant1', name: 'dashboard')]
    public function dashboard(): Response
    {
        return $this->render('restaurant/dashboard.html.twig', [
            'controller_name' => 'RestaurantController',
        ]);
    }

    #[Route('/restaurant/ajout', name: 'ajoutRes')]
    public function ajouter(ManagerRegistry $doctrine, Request $request, RestaurantRepository $restaurantRepository): Response
    {

        $restaurant = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $restaurant);

        $form->handleRequest($request);
        $checkSiNomRestaurantExiste=$restaurantRepository->findBy(['nom_restaurant'=>$form->get('nom_restaurant')->getViewData()]);
        if($form->isSubmitted()&& $form->isValid())
        {
            if ($checkSiNomRestaurantExiste!=null)
            {
                $this->addFlash('error','ce restaurant existe déjà dans la base !');
            }else
            {
                //$restaurant->setUpdatedAt(new \DateTimeImmutable());
                //$restaurant->setCreatedAt(new \DateTimeImmutable());
                // la méthode add permet de persiter et de flush en même temps
                $restaurantRepository->add($restaurant, true);
                $this->addFlash('success','Enregistrement Réussi !');
            }
        }

        return $this->render('restaurant/ajout.html.twig', [
            'form' => $form->createView(),
            'restaurant'=>$restaurantRepository->findAll()
        ]);

    }


    #[Route('/restaurant', name: 'listeRestau')]
    public function listeRestau(ManagerRegistry $doctrine): Response
    {

        $repository = $doctrine->getRepository(Restaurant::class);
        $restaurant= $repository->findAll();
        return $this->render('restaurant/listerestau.html.twig', [
            'restaurants'=>$restaurant

        ]);
    }


    #[Route('/detailR', name: 'detailRestau')]
    public function detailRestau(ManagerRegistry $doctrine, $id): Response
    {

        $repository = $doctrine->getRepository(Restaurant::class);
        $restaurant= $repository->find($id);
        if(!$restaurant){

           $this->addFlash('error', 'le restaurant avec cet identifiant n existe pas');
           return $this->redirectToRoute('restaurant');

        }
        return $this->render('restaurant/detailrestau.html.twig', [
            'restaurants'=>$restaurant

        ]);
    }
}
