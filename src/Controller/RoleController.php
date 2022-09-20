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
         $forms=$this->createForm(RoleType::class,$role);
         $forms->remove('staut');
         $forms->remove('createdAt');
         $forms->remove('updatedAt');
         $forms->remove('privillege');
         $forms->handleRequest($request);
         $roleName=$forms->get('roleName')->getViewData();
         $manage=$doctrine->getRepository(Role::class);
         $find=$manage->findBy(['roleName'=>$roleName]);
         if ($forms->isSubmitted())
         {
             if ($find!=null)
             {
                 $this->addFlash('error','ce role existe déjà dans la base de données!');
             }
             else
             {
                 $this->addFlash('success','enregistrement réussi!');
                 $role->setStatut('Actif');
                 $role->setCreatedAt(new \DateTimeImmutable('now'));
                 $role->setUpdatedAt(new \DateTimeImmutable('now'));
                 $manager=$doctrine->getManager();
                 $manager->persist($role);
                 $manager->flush();
             }
         }
        $repository = $doctrine->getRepository(Role::class);
        $role=$repository->findAll();
        return $this->render('role/addRole.html.twig',[
            'formRole'=> $forms->createView(),
            'roles'=>$role
        ]);
    }
    #[Route('/supprimerRole', name: 'supprimer.role')]
    public function supprimerRole(ManagerRegistry $doctrine, Role $role= null): Response
    {
        $entite = $doctrine->getManager();
        if ($role) {
            $entite->remove($role);
            $entite->flush();
            $this->addFlash('success', 'Suppression Réussi !');
        }
        else
        {
            $this->addFlash('error',"ce role n'existe pas dans la base !");
        }
        return new Response();
    }
    #[Route('/montrerRoles', name:'montrer.roles')]
    public function afficherRoles(ManagerRegistry $doctrine):Response
    {

        return $this->render('role/addRole.html.twig',[
            'roles'=> $role
        ]);
    }

    #[
        Route('/alls', name: 'list.alls')
    ]
    public function indexAlls(ManagerRegistry $doctrine, $page, $nbre): Response {
        $repository = $doctrine->getRepository(Role::class);
        $nbRole = $repository->count([]);
        $nbrePage = ceil($nbRole / $nbre) ;

        $role = $repository->findBy([], [],$nbre, ($page - 1 ) * $nbre);
        $listAllPersonneEvent = new ListAllPersonnesEvent(count($role));
        $this->dispatcher->dispatch($listAllPersonneEvent, ListAllPersonnesEvent::LIST_ALL_PERSONNE_EVENT);

        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes,
            'isPaginated' => true,
            'nbrePage' => $nbrePage,
            'page' => $page,
            'nbre' => $nbre
        ]);
    }
}
