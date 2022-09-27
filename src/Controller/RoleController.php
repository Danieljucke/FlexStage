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
    public function index(Request $request,RoleRepository $roleRepository): Response
    {
         $role = new Role();
         $forms=$this->createForm(RoleType::class,$role);
         $forms->remove('staut');
         $forms->remove('createdAt');
         $forms->remove('updatedAt');
         $forms->handleRequest($request);
        // je check dans la BDD si le nom que je récupère dans le formulaire existe dans la base ou pas si oui alors je pose une condition
         $find=$roleRepository->findBy(['roleName'=>$forms->get('roleName')->getViewData()]);
         if ($forms->isSubmitted())
         {
             if ($find!=null)
             {
                 $this->addFlash('error','ce role existe déjà dans la base de données!');
             }
             else
             {
                 $role->setStatut('Actif');
                 $role->setCreatedAt(new \DateTimeImmutable('now'));
                 $role->setUpdatedAt(new \DateTimeImmutable('now'));
                 $roleRepository->add($role,true);// la méthode add permet de persiter et de flush en même temps
                 $this->addFlash('success','enregistrement réussi!');
             }
         }
        return $this->render('role/addRole.html.twig',[
            'formRole'=> $forms->createView(),
            'roles'=>$roleRepository->findAll()
        ]);
    }

    #[Route('/montrerRole/{id}', name: 'montrer.role')]
    public function montrerRole(Role $role=null): Response
    {
        return $this->render('role/detailRole.html.twig', [
            'role' => $role,
        ]);
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
