<?php

namespace App\Controller;

use App\Form\ReservationFormType;
use App\Entity\Reservations;
use App\Repository\SchedulesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/reserver', name: 'booking')]
    public function reservation(Request $request, SchedulesRepository $schedulesRepository): Response
    {
        $reservation = new Reservations();
        $reservation->setDateTime(new \DateTimeImmutable());
        $form = $this->createForm(ReservationFormType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Actions
            $this->entityManager->persist($reservation);
            $this->entityManager->flush();

            // Redirect to success page
            return $this->redirectToRoute('booking_success');
        }

        $schedules = $schedulesRepository->findAll();

        return $this->render('front/booking/index.html.twig', [
            'form' => $form->createView(),
            'schedules' => $schedules
        ]);
    }

    #[Route('/reserver/confirmation', name: 'booking_success')]
    public function success(SchedulesRepository $schedulesRepository): Response
    {
        // Success page
        $schedules = $schedulesRepository->findAll();
        return $this->render('front/booking/success.html.twig', [
            'schedules' => $schedules
        ]);
    }
}
