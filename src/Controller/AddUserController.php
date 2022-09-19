<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddUserController extends AbstractController
{
    #[Route('/add/user', name: 'app_add_user')]
    public function index(Request $request, EntityManager $manager): Response
    {
        $utilisateur = new User();


        return $this->render('add_user/index.html.twig', [
            'controller_name' => 'AddUserController',
        ]);
    }
}
