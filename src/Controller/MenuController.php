<?php

namespace App\Controller;

use App\Repository\DishesCategoriesRepository;
use App\Repository\DishesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    #[Route('/notre-carte', name: 'menu', methods: ['GET'])]
    public function index(DishesCategoriesRepository $dishesCategoriesRepository, DishesRepository $dishesRepository): Response
    {
        $dishesCategories = $dishesCategoriesRepository->findAll();
        $dishes = $dishesRepository->findAll();
        return $this->render('/front/menu/index.html.twig', [
            'controller_name' => 'MenuController',
            'dishesCategories' => $dishesCategories,
            'dishes' => $dishes
        ]);
    }
}
