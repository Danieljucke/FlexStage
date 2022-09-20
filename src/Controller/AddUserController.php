<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Form\AddUserType;
use App\Repository\RoleRepository;
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
        // Création de l'objet formulaire
        $form = $this->createForm(AddUserType::class, $utilisateur);
        $form->remove('createdAt');
        $form->remove('updatedAt');

        // On récupère les données inscrites dans le formulaire
        $form->handleRequest($request);
        $utilisateur-> setCreatedAt(new \DateTimeImmutable('now'));
        $utilisateur-> setUpdatedAt(new \DateTimeImmutable('now'));


        // Verifier si le formulaire est déjà soummis
        if ($form->isSubmitted()){

            // Si oui on enregistre les données de la requête dans la table
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            // Afficher la liste de tous les utilisateurs
            ;


            // rediriger vers une page
            return $this->redirectToRoute('app_add_user');

        } else{

            return $this->render('add_user/addUser.html.twig', [
                'form' => $form->createView(),

            ]);
        }


    }
}
