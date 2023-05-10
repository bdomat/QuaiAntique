<?php

namespace App\Entity;

use App\Repository\ReservationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
class Reservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $reservation_name = null;

    #[ORM\Column(length: 15)]
    private ?string $reservation_phone = null;

    #[ORM\Column(type: 'integer')]
    private ?int $guests_number = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $date_time = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Users $user = null;

    #[ORM\OneToOne(mappedBy: 'reservation', cascade: ['persist', 'remove'])]
    private ?Tables $tables = null;

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

    public function setDateTime(\DateTimeInterface $date_time): self
    {
        if ($date_time instanceof \DateTimeImmutable) {
            $this->date_time = $date_time;
        } else {
            $this->date_time = \DateTimeImmutable::createFromMutable($date_time);
        }

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTables(): ?Tables
    {
        return $this->tables;
    }

    public function setTables(?Tables $tables): self
    {
        // unset the owning side of the relation if necessary
        if ($tables === null && $this->tables !== null) {
            $this->tables->setReservation(null);
        }

        // set the owning side of the relation if necessary
        if ($tables !== null && $tables->getReservation() !== $this) {
            $tables->setReservation($this);
        }

        $this->tables = $tables;

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
