<?php

namespace App\Controller;

use App\Repository\DishesCategoriesRepository;
use App\Repository\DishesRepository;
use App\Repository\FormulasRepository;
use App\Repository\MenusRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    #[Route('/notre-carte', name: 'menu', methods: ['GET'])]
    public function index(DishesCategoriesRepository $dishesCategoriesRepository, DishesRepository $dishesRepository, MenusRepository $menusRepository, FormulasRepository $formulasRepository): Response
    {
        $dishesCategories = $dishesCategoriesRepository->findAll();
        $dishes = $dishesRepository->findAll();
        $menus = $menusRepository->findAll();
        $formulas = $formulasRepository->findAll();
        return $this->render('/front/menu/index.html.twig', [
            'controller_name' => 'MenuController',
            'dishesCategories' => $dishesCategories,
            'dishes' => $dishes,
            'menus' => $menus,
            'formulas' => $formulas
        ]);
    }
}
