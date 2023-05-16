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
        $restaurant = $restaurantsRepository->findOneBy([]); // Assuming there's only one restaurant
        $guestThreshold = $restaurant->getGuestThreshold();

        // Get the schedule for the selected date and time
        $schedule = $schedulesRepository->findScheduleForDateTime($date_time);

        // Check if schedule is null
        if ($schedule === null) {
            // Handle the error, for example return a response or throw an exception
            return $this->json([
                'error' => 'No schedule found for the provided date and time',
                'remainingSeats' => 0,
            ], Response::HTTP_NOT_FOUND);
        }

        // Get the total number of guests already reserved for the selected service
        $totalGuestsReserved = $reservationsRepository->findTotalGuestsForService($schedule);

        // Calculate the remaining seats
        $remainingSeats = $guestThreshold - $totalGuestsReserved;

        return $this->json([
            'remainingSeats' => $remainingSeats >= 0 ? $remainingSeats : 0,
        ]);
    }
}
