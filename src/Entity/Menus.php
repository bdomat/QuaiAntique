<?php

namespace App\Entity;

use App\Repository\MenusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenusRepository::class)]
class Menus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $menu_entry = null;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: Formulas::class)]
    private Collection $formulas;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $menu_main_course = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $menu_dessert = null;

    public function __construct()
    {
        $this->formulas = new ArrayCollection();
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

    public function getMenuEntry(): ?string
    {
        return $this->menu_entry;
    }
    public function getMenu_Entry(): ?string
    {
        return $this->menu_entry;
    }

    public function setMenuEntry(string $menu_entry): self
    {
        $this->menu_entry = $menu_entry;

        return $this;
    }

    /**
     * @return Collection<int, Formulas>
     */
    public function getFormulas(): Collection
    {
        return $this->formulas;
    }

    public function addFormula(Formulas $formula): self
    {
        if (!$this->formulas->contains($formula)) {
            $this->formulas->add($formula);
            $formula->setMenu($this);
        }

        return $this;
    }

    public function removeFormula(Formulas $formula): self
    {
        if ($this->formulas->removeElement($formula)) {
            // set the owning side to null (unless already changed)
            if ($formula->getMenu() === $this) {
                $formula->setMenu(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->title;
    }

    public function getMenuMainCourse(): ?string
    {
        return $this->menu_main_course;
    }
    public function getMenu_Main_Course(): ?string
    {
        return $this->menu_main_course;
    }

    public function setMenuMainCourse(?string $menu_main_course): self
    {
        $this->menu_main_course = $menu_main_course;

        return $this;
    }

    public function getMenuDessert(): ?string
    {
        return $this->menu_dessert;
    }
    public function getMenu_Dessert(): ?string
    {
        return $this->menu_dessert;
    }

    public function setMenuDessert(?string $menu_dessert): self
    {
        $this->menu_dessert = $menu_dessert;

        return $this;
    }
}
