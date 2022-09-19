<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AddUserType;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddUserController extends AbstractController
{
    #[Route('/add/user', name: 'app_add_user')]
    public function index(Request $request, ManagerRegistry $manager): Response
    {
        $entityManager = $manager->getManager();

        $utilisateur = new User();

        $form = $this->createForm(AddUserType::class, $utilisateur);
        $form->remove('createdAt');
        $form->remove('updatedAt');

        return $this->render('add_user/addUser.html.twig', [
            'form' => $form->createView()

        ]);
    }
}
