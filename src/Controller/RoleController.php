<?php

namespace App\Controller;

use App\Entity\Role;
use App\Form\RoleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleController extends AbstractController
{
    #[Route('/role', name: 'app_role')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $role = new Role();
        $manager=$doctrine->getManager();
        $form=$this->createForm(RoleType::class,$role);
        $form->remove('privillege');
        $form->remove('statut');
        $form->remove('createdAt');
        $form->remove('updatedAt');
        $role->setUpdatedAt(new \DateTimeImmutable());
        $role->setCreatedAt(new \DateTimeImmutable());
        $role->setStatut('Actif');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->addFlash('success','Enregistrement Réussi !');

        }
        $manager->persist($role);
        $manager->flush();
        return $this->render('role/addRole.html.twig',[
            'formRole'=>$form->createView()
        ]);
    }
}
