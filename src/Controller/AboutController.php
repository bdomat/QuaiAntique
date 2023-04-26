<?php

namespace App\Controller;

use App\Repository\SchedulesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    #[Route('/le-chef-michant', name: 'about')]
    public function index(SchedulesRepository $schedulesRepository): Response
    {
        $schedules = $schedulesRepository->findAll();
        return $this->render('/front/about/index.html.twig', [
            'controller_name' => 'AboutController',
            'schedules' => $schedules
        ]);
    }
}
