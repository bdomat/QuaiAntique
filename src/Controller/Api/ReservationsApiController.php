<?php

namespace App\Controller\Api;

use App\Repository\RestaurantsRepository;
use App\Repository\ReservationsRepository;
use App\Repository\SchedulesRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ReservationsApiController extends AbstractController
{
    private $reservationsRepository;
    private $restaurantsRepository;

    public function __construct(ReservationsRepository $reservationsRepository, RestaurantsRepository $restaurantsRepository)
    {
        $this->reservationsRepository = $reservationsRepository;
        $this->restaurantsRepository = $restaurantsRepository;
    }

    #[Route('/api/remainingSeats/{date_time}', name: 'api_remaining_seats', methods: ['GET'])]
    public function remainingSeats(\DateTimeInterface $date_time, ReservationsRepository $reservationsRepository, RestaurantsRepository $restaurantsRepository, SchedulesRepository $schedulesRepository): Response
    {
        // Get the restaurant's guest threshold
        $restaurant = $restaurantsRepository->findOneBy([]);
        $guestThreshold = $restaurant->getGuestThreshold();

        // Get the schedule for the selected date and time
        $schedule = $schedulesRepository->findScheduleForDateTime($date_time);

        // Check if schedule is null
        if ($schedule === null) {
            // Handle the error, for example return a response or throw an exception
            return $this->json([
                'error' => 'Le restaurant est fermé à la date et/ou l\'heure sélectionnée',
                'remainingSeats' => 0,
            ], Response::HTTP_NOT_FOUND);
        }

        // Check if the selected time is within the last hour before closing
        $closingHour = (new \DateTime($date_time->format('Y-m-d') . ' ' . $schedule->getClosingHour()->format('H:i:s')));
        $lastHourBeforeClosing = (clone $closingHour)->modify('-1 hour');

        if ($date_time >= $lastHourBeforeClosing && $date_time < $closingHour) {
            return $this->json([
                'error' => 'Les réservations ne sont pas autorisées pendant la dernière heure avant la fermeture',
                'remainingSeats' => 0,
            ], Response::HTTP_BAD_REQUEST);
        }

        // Also check if the selected time is after the closing time
        if ($date_time >= $closingHour) {
            return $this->json([
                'error' => 'Le restaurant est fermé à la date et/ou l\'heure sélectionnée',
                'remainingSeats' => 0,
            ], Response::HTTP_BAD_REQUEST);
        }

        // Get the total number of guests already reserved for the selected service
        $totalGuestsReserved = $reservationsRepository->findTotalGuestsForService($date_time, $schedule);

        // Calculate the remaining seats
        $remainingSeats = $guestThreshold - $totalGuestsReserved;

        return $this->json([
            'remainingSeats' => $remainingSeats >= 0 ? $remainingSeats : 0,
        ]);
    }
}
