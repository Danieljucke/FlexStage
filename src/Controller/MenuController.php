<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    #[Route('/menu', name: 'app_menu')]
    public function index(): Response
    {
        return $this->render('menu/index.html.twig', [
            'controller_name' => 'MenuController',
        ]);
    }

    #[Route('/menu/ajout', name: 'ajouMenu')]
    public function ajouter(): Response
    {
        return $this->render('menu/ajouMenu.html.twig', [
            'controller_name' => 'MenuController',
        ]);
    }
}
