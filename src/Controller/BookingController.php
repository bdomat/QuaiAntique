<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    #[Route('/reserver', name: 'booking')]
    public function index(): Response
    {
        return $this->render('/front/booking/index.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }
}
