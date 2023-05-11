<?php

namespace App\Controller;

use App\Form\ReservationFormType;
use App\Entity\Reservations;
use App\Entity\Users;
use App\Repository\SchedulesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class BookingController extends AbstractController
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    #[Route('/reserver', name: 'booking')]
    public function reservation(Request $request, SchedulesRepository $schedulesRepository): Response
    {
        $reservation = new Reservations();

        // Get the currently logged in user
        $user = $this->security->getUser();
        // Set the user to the reservation
        if ($user) {
            $reservation->setUser($user);
            $reservation->setGuestsNumber($user->getDefaultGuestsNumber());
            $reservation->setAllergies($user->getAllergies());
        } else {
            //default guests number for disconnected users
            $reservation->setGuestsNumber(1);
        }

        $form = $this->createForm(ReservationFormType::class, $reservation, [
            'schedules_repository' => $schedulesRepository,
        ]);
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
