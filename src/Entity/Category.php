<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'parent_category', targetEntity: Dishes::class)]
    private Collection $dish;

    public function __construct()
    {
        $this->dish = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Dishes>
     */
    public function getDish(): Collection
    {
        return $this->dish;
    }

    public function addDish(Dishes $dish): self
    {
        if (!$this->dish->contains($dish)) {
            $this->dish->add($dish);
            $dish->setParentCategory($this);
        }

        return $this;
    }

    public function removeDish(Dishes $dish): self
    {
        if ($this->dish->removeElement($dish)) {
            // set the owning side to null (unless already changed)
            if ($dish->getParentCategory() === $this) {
                $dish->setParentCategory(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->title;
    }
}
