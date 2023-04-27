<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    private ?Chambre $Chambre = null;

    #[ORM\ManyToMany(targetEntity: Restauration::class, inversedBy: 'inscriptions')]
    private Collection $Restauration;

    #[Assert\Count(
            min: 1,
            max: 5,
    )]
    #[ORM\ManyToMany(targetEntity: Atelier::class, mappedBy: 'Inscriptions')]
    private Collection $ateliers;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    private ?User $user = null;

    public function __construct()
    {
        $this->Restauration = new ArrayCollection();
        $this->ateliers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChambre(): ?Chambre
    {
        return $this->Chambre;
    }

    public function setChambre(?Chambre $Chambre): self
    {
        $this->Chambre = $Chambre;

        return $this;
    }

    /**
     * @return Collection<int, Restauration>
     */
    public function getRestauration(): Collection
    {
        return $this->Restauration;
    }

    public function addRestauration(Restauration $restauration): self
    {
        if (!$this->Restauration->contains($restauration)) {
            $this->Restauration->add($restauration);
        }

        return $this;
    }

    public function removeRestauration(Restauration $restauration): self
    {
        $this->Restauration->removeElement($restauration);

        return $this;
    }

    /**
     * @return Collection<int, Atelier>
     */
    public function getAteliers(): Collection
    {
        return $this->ateliers;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
