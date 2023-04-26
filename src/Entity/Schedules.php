<?php

namespace App\Entity;

use App\Repository\SchedulesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SchedulesRepository::class)]
class Schedules
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $day = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $opening_hour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closing_hour = null;

    #[ORM\Column]
    private ?bool $is_active = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(?string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getOpeningHour(): ?\DateTimeInterface
    {
        return $this->opening_hour;
    }
    public function getOpening_Hour(): ?\DateTimeInterface
    {
        return $this->opening_hour;
    }

    public function setOpeningHour(\DateTimeInterface $opening_hour): self
    {
        $this->opening_hour = $opening_hour;

        return $this;
    }

    public function getClosingHour(): ?\DateTimeInterface
    {
        return $this->closing_hour;
    }
    public function getClosing_Hour(): ?\DateTimeInterface
    {
        return $this->closing_hour;
    }

    public function setClosingHour(\DateTimeInterface $closing_hour): self
    {
        $this->closing_hour = $closing_hour;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->is_active;
    }
    public function getis_active(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }
}
