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
#[Route('/role'), IsGranted("IS_AUTHENTICATED_FULLY")]
class RoleController extends AbstractController
{
    #[Route('/voir', name: 'app_role'),IsGranted("ROLE_ADMIN")]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
         $role = new Role();
         $forms=$this->createForm(RoleType::class,$role);
         $forms->remove('staut');
         $forms->remove('createdAt');
         $forms->remove('updatedAt');
//         $forms->remove('privillege');
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

    #[Route('/montrerRole/{id}', name: 'montrer.role')]
    public function montrerRole(Role $role=null): Response
    {
//        return $this->render('users/show.html.twig', [
//            'role' => $role,
//        ]);
        return new Response();
    }
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
    #[Route('/supprimerRole/{id}', name: 'supprimer.role')]
    public function supprimerRole(Role $role=null, RoleRepository $roleRepository): Response
    {
        if ($role) {
            $roleRepository->remove($role, true);
            $this->addFlash('success','Suppression Réussi !');
        }else
        {
            $this->addFlash('error','Opération Echoué !');
        }
        return $this->redirectToRoute('app_role');
    }


}
