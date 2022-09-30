<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $nom_menu = null;

    #[ORM\Column]
    public ?int $nombre_plat = null;

    #[ORM\ManyToMany(targetEntity: Plat::class, inversedBy: 'menus')]
    private Collection $Plat;

    #[ORM\ManyToOne(inversedBy: 'menu')]
    private ?Restaurant $restaurant = null;

    public function __construct()
    {
        $this->Plat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMenu(): ?string
    {
        return $this->nom_menu;
    }

    public function setNomMenu(string $nom_menu): self
    {
        $this->nom_menu = $nom_menu;

        return $this;
    }

    public function getNombrePlat(): ?int
    {
        return $this->nombre_plat;
    }

    public function setNombrePlat(int $nombre_plat): self
    {
        $this->nombre_plat = $nombre_plat;

        return $this;
    }

    /**
     * @return Collection<int, Plat>
     */
    public function getPlat(): Collection
    {
        return $this->Plat;
    }

    public function addPlat(Plat $plat): self
    {
        if (!$this->Plat->contains($plat)) {
            $this->Plat->add($plat);
        }

        return $this;
    }

    public function removePlat(Plat $plat): self
    {
        $this->Plat->removeElement($plat);

        return $this;
    }

    /**
     * @return Collection<int, Restaurant>
     */
    public function getRestaurant(): Collection
    {
        return $this->Restaurant;
    }

    public function addRestaurant(Restaurant $restaurant): self
    {
        if (!$this->Restaurant->contains($restaurant)) {
            $this->Restaurant->add($restaurant);
            $restaurant->setMenu($this);
        }

        return $this;
    }

    public function removeRestaurant(Restaurant $restaurant): self
    {
        if ($this->Restaurant->removeElement($restaurant)) {
            // set the owning side to null (unless already changed)
            if ($restaurant->getMenu() === $this) {
                $restaurant->setMenu(null);
            }
        }

        return $this;
    }

    public function setRestaurant(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

}
