<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    #[Route('/le-chef-michant', name: 'about')]
    public function index(): Response
    {
        return $this->render('/front/about/index.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }
}
