<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\RestaurantType;
use Doctrine\Persistence\ManagerRegistry;
use MongoDB\Driver\Manager;
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
    public function ajouter(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $Restaurant = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $Restaurant);

        $form->handleRequest($request);
        if($form->isSubmitted()){

            dd ($Restaurant);
        }
        else{

            return $this->render('restaurant/ajout.html.twig', [
                'form' => $form->createView()
            ]);

        }



    }


    #[Route('/restaurant/liste', name: 'listeRes')]
    public function liste(): Response
    {
        return $this->render('restaurant/listerestau.html.twig', [
            'controller_name' => 'RestaurantController',
        ]);
    }
}
