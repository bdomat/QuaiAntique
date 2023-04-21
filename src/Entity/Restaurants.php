<?php

namespace App\Entity;

use App\Repository\RestaurantsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurantsRepository::class)]
class Restaurants
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $guest_threshold = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGuestThreshold(): ?int
    {
        return $this->guest_threshold;
    }

    public function setGuestThreshold(int $guest_threshold): self
    {
        $this->guest_threshold = $guest_threshold;

        return $this;
    }
}
