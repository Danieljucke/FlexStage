<?php

namespace App\Controller;

use App\Entity\Role;
use App\Form\RoleType;
use App\Repository\RoleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleController extends AbstractController
{
    #[Route('/role', name: 'app_role'),IsGranted("ROLE_ADMIN")]
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

//    #[Route('/{id}', name: 'montrer.role', methods: ['GET'])]
//    public function montrer(Role $role): Response
//    {
////        return $this->render('users/show.html.twig', [
////            'role' => $role,
////        ]);
//        return new Response();
//    }
//    #[Route('/{id}/modifier', name: 'modifier.role', methods: ['GET', 'POST'])]
//    public function modifier(Request $request, Role $role, RoleRepository $roleRepository): Response
//    {
//        $form = $this->createForm(RoleType::class, $role);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $roleRepository->add($role, true);
//
//            return $this->redirectToRoute('app_role');
//        }
//
////        return $this->renderForm('users/edit.html.twig', [
////            'role' => $role,
////            'form' => $form,
////        ]);
//        return new Response();
//    }
//    #[Route('/{id}', name: 'supprimer.role', methods: ['POST'])]
//    public function supprimer(Request $request, Role $role, RoleRepository $roleRepository): Response
//    {
//        if ($this->isCsrfTokenValid('delete'.$role->getId(), $request->request->get('_token'))) {
//            $roleRepository->remove($role, true);
//        }
//        return $this->redirectToRoute('app_role');
//    }
//
////    #[
////        Route('/alls', name: 'list.alls')
////    ]
////    public function indexAlls(ManagerRegistry $doctrine, $page, $nbre): Response {
////        $repository = $doctrine->getRepository(Role::class);
////        $nbRole = $repository->count([]);
////        $nbrePage = ceil($nbRole / $nbre) ;
////
////        $role = $repository->findBy([], [],$nbre, ($page - 1 ) * $nbre);
////        $listAllPersonneEvent = new ListAllPersonnesEvent(count($role));
////        $this->dispatcher->dispatch($listAllPersonneEvent, ListAllPersonnesEvent::LIST_ALL_PERSONNE_EVENT);
////
////        return $this->render('personne/login.html.twig', [
////            'personnes' => $personnes,
////            'isPaginated' => true,
////            'nbrePage' => $nbrePage,
////            'page' => $page,
////            'nbre' => $nbre
////        ]);
////    }
}
