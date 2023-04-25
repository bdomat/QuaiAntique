<?php

namespace App\Controller;

use App\Repository\ImagesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ImagesRepository $imagesRepository): Response
    {
        $images = $imagesRepository->findAll();
        return $this->render('/front/index.html.twig', [
            'controller_name' => 'HomeController',
            'images' => $images
        ]);
    }
}
