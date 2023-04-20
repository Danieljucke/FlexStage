<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use http\Env\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class

MenuController extends AbstractController
{
    #[Route('/menu', name: 'app_menu')]
    public function index(): Response
    {
        return $this->render('menu/index.html.twig', [
            'controller_name' => 'MenuController',
        ]);
    }

    #[Route('/menu/ajout', name: 'ajouMenu')]
    public function ajouter(ManagerRegistry $doctrine, \Symfony\Component\HttpFoundation\Request $request, MenuRepository $menuRepository): Response
    {

        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);
        $checkSiNomMenuExiste=$menuRepository->findBy(['nom_menu'=>$form->get('nom_menu')->getViewData()]);
        if($form->isSubmitted()&& $form->isValid())
        {
            if ($checkSiNomMenuExiste!=null)
            {
                $this->addFlash('error','cette categorie existe déjà dans la base !');
            }else
            {
                //$restaurant->setUpdatedAt(new \DateTimeImmutable());
                //$restaurant->setCreatedAt(new \DateTimeImmutable());
                // la méthode add permet de persiter et de flush en même temps
                $menuRepository->add($menu, true);
                $this->addFlash('success','Enregistrement Réussi !');
            }
        }

        return $this->render('menu/ajouMenu.html.twig', [
            'form' => $form->createView(),
            'menu'=>$menuRepository->findAll()
        ]);


    }
    #[Route('/menu/liste', name: 'listeMenu')]
    public function listeMenu(ManagerRegistry $doctrine): Response

    {
        $repository= $doctrine->getRepository(Menu::class);
        $menu= $repository->findAll();
        return $this->render('menu/listeMenu.html.twig', [
            'menu' => $menu,
        ]);
    }
}
