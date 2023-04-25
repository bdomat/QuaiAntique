<?php

namespace App\Entity;

use App\Repository\DishesCategoriesRepository;
use App\Repository\DishesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DishesRepository::class)]
class Dishes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 10)]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'dish')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DishesCategories $parent_category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getParentCategory(): ?DishesCategories
    {
        return $this->parent_category;
    }
    public function getParent_Category(): ?DishesCategories
    {
        return $this->parent_category;
    }

    public function setParentCategory(?DishesCategories $parent_category): self
    {
        $this->parent_category = $parent_category;

        return $this;
    }
    public function __toString()
    {
        return $this->title;
    }
}
