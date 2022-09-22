<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HotelRepository::class)]
class Hotel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_hotel = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $nombre_etoiles = null;

    #[ORM\ManyToMany(targetEntity: CategorieHotel::class)]
    private Collection $categorie;

    #[ORM\ManyToOne(inversedBy: 'hotels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ville $adresse = null;

    public function __construct()
    {
        $this->categorie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomHotel(): ?string
    {
        return $this->nom_hotel;
    }

    public function setNomHotel(string $nom_hotel): self
    {
        $this->nom_hotel = $nom_hotel;

        return $this;
    }

    public function getNombreEtoiles(): ?int
    {
        return $this->nombre_etoiles;
    }

    public function setNombreEtoiles(int $nombre_etoiles): self
    {
        $this->nombre_etoiles = $nombre_etoiles;

        return $this;
    }

    /**
     * @return Collection<int, CategorieHotel>
     */
    public function getCategorie(): Collection
    {
        return $this->categorie;
    }

    public function addCategorie(CategorieHotel $categorie): self
    {
        if (!$this->categorie->contains($categorie)) {
            $this->categorie->add($categorie);
        }

        return $this;
    }

    public function removeCategorie(CategorieHotel $categorie): self
    {
        $this->categorie->removeElement($categorie);

        return $this;
    }

    public function getAdresse(): ?Ville
    {
        return $this->adresse;
    }

    public function setAdresse(?Ville $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }
}
