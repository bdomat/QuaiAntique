<?php

namespace App\Controller;

use App\Repository\SchedulesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    #[Route('/reserver', name: 'booking')]
    public function index(SchedulesRepository $schedulesRepository): Response
    {
        $schedules = $schedulesRepository->findAll();
        return $this->render('/front/booking/index.html.twig', [
            'controller_name' => 'BookingController',
            'schedules' => $schedules
        ]);
    }
}
