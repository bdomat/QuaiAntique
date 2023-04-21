<?php

namespace App\Controller;

use App\Repository\DishesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    #[Route('/notre-carte', name: 'menu')]
    public function index(DishesRepository $dishesRepository): Response
    {
        return $this->render('/front/menu/index.html.twig', [
            'controller_name' => 'MenuController',
            'dishes' => $dishesRepository->findAll()
        ]);
    }
}
