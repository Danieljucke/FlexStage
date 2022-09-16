<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $roleName = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\OneToMany(mappedBy: 'role', targetEntity: User::class, orphanRemoval: true)]
    private Collection $users;

    #[ORM\ManyToMany(targetEntity: Privillege::class, inversedBy: 'roles')]
    private Collection $privillege;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->privillege = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoleName(): ?string
    {
        return $this->roleName;
    }

    public function setRoleName(string $roleName): self
    {
        $this->roleName = $roleName;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setRole($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getRole() === $this) {
                $user->setRole(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Privillege>
     */
    public function getPrivillege(): Collection
    {
        return $this->privillege;
    }

    public function addPrivillege(Privillege $privillege): self
    {
        if (!$this->privillege->contains($privillege)) {
            $this->privillege->add($privillege);
        }

        return $this;
    }

    public function removePrivillege(Privillege $privillege): self
    {
        $this->privillege->removeElement($privillege);

        return $this;
    }
}
