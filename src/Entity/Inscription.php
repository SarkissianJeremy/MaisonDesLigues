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

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    private ?User $Participant = null;

    #[ORM\ManyToMany(targetEntity: Restauration::class, inversedBy: 'inscriptions')]
    private Collection $Restauration;

    #[ORM\ManyToMany(targetEntity: Atelier::class, inversedBy: 'inscriptions')]
    private Collection $Atelier;

    #[ORM\ManyToMany(targetEntity: Atelier::class, mappedBy: 'Inscriptions')]
    private Collection $ateliers;

    public function __construct()
    {
        $this->Restauration = new ArrayCollection();
        $this->Atelier = new ArrayCollection();
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

    public function getParticipant(): ?User
    {
        return $this->Participant;
    }

    public function setParticipant(?User $Participant): self
    {
        $this->Participant = $Participant;

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
    public function getAtelier(): Collection
    {
        return $this->Atelier;
    }

    public function addAtelier(Atelier $atelier): self
    {
        if (!$this->Atelier->contains($atelier)) {
            $this->Atelier->add($atelier);
        }

        return $this;
    }

    public function removeAtelier(Atelier $atelier): self
    {
        $this->Atelier->removeElement($atelier);

        return $this;
    }

    /**
     * @return Collection<int, Atelier>
     */
    public function getAteliers(): Collection
    {
        return $this->ateliers;
    }
}
