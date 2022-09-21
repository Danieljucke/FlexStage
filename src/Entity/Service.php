<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom_service = null;

    #[ORM\Column(length: 100)]
    private ?string $code_service = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: Salle::class, orphanRemoval: true)]
    private Collection $salle;

    public function __construct()
    {
        $this->salle = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomService(): ?string
    {
        return $this->nom_service;
    }

    public function setNomService(string $nom_service): self
    {
        $this->nom_service = $nom_service;

        return $this;
    }

    public function getCodeService(): ?string
    {
        return $this->code_service;
    }

    public function setCodeService(string $code_service): self
    {
        $this->code_service = $code_service;

        return $this;
    }

    /**
     * @return Collection<int, Salle>
     */
    public function getSalle(): Collection
    {
        return $this->salle;
    }

    public function addSalle(Salle $salle): self
    {
        if (!$this->salle->contains($salle)) {
            $this->salle->add($salle);
            $salle->setService($this);
        }

        return $this;
    }

    public function removeSalle(Salle $salle): self
    {
        if ($this->salle->removeElement($salle)) {
            // set the owning side to null (unless already changed)
            if ($salle->getService() === $this) {
                $salle->setService(null);
            }
        }

        return $this;
    }
}
