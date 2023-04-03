<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/connexion', name: 'login')]
    public function index(): Response
    {
        return $this->render('/front/login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }
}
