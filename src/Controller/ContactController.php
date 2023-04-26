<?php

namespace App\Controller;

use App\Repository\SchedulesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(SchedulesRepository $schedulesRepository): Response
    {
        $schedules = $schedulesRepository->findAll();
        return $this->render('/front/contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'schedules' => $schedules
        ]);
    }
}
