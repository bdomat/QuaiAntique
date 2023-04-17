<?php

namespace App\Entity;

use App\Repository\ReservationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
class Reservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $reservation_name = null;

    #[ORM\Column(length: 15)]
    private ?string $reservation_phone = null;

    #[ORM\Column]
    private ?int $guests_number = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_time = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Users $user_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservationName(): ?string
    {
        return $this->reservation_name;
    }

    public function setReservationName(string $reservation_name): self
    {
        $this->reservation_name = $reservation_name;

        return $this;
    }

    public function getReservationPhone(): ?string
    {
        return $this->reservation_phone;
    }

    public function setReservationPhone(string $reservation_phone): self
    {
        $this->reservation_phone = $reservation_phone;

        return $this;
    }

    public function getGuestsNumber(): ?int
    {
        return $this->guests_number;
    }

    public function setGuestsNumber(int $guests_number): self
    {
        $this->guests_number = $guests_number;

        return $this;
    }

    public function getDateTime(): ?\DateTimeImmutable
    {
        return $this->date_time;
    }

    public function setDateTime(\DateTimeImmutable $date_time): self
    {
        $this->date_time = $date_time;

        return $this;
    }

    public function getUserId(): ?Users
    {
        return $this->user_id;
    }

    public function setUserId(?Users $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
