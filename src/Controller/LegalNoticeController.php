<?php

namespace App\Controller;

use App\Repository\SchedulesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LegalNoticeController extends AbstractController
{
    #[Route('/mentions-legales', name: 'legal_notice')]
    public function index(SchedulesRepository $schedulesRepository): Response
    {
        $schedules = $schedulesRepository->findAll();
        return $this->render('/front/legal_notice/index.html.twig', [
            'controller_name' => 'LegalNoticeController',
            'schedules' => $schedules
        ]);
    }
}
