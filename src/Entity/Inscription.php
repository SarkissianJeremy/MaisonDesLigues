<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use SymfonyComponent\Validator\Constraintes as Assert;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Restauration::class, inversedBy: 'inscriptions')]
    private Collection $Restauration;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    private ?User $user = null;

    #[Assert\Count(
            min: 1,
            max: 5,
    )]
    #[ORM\ManyToMany(targetEntity: Atelier::class, inversedBy: 'inscriptions')]
    private Collection $ateliers;

    #[ORM\ManyToMany(targetEntity: Chambre::class, inversedBy: 'inscriptions')]
    private Collection $Chambres;

    #[ORM\Column]
    private ?bool $is_validated = null;

    public function __construct()
    {
        $this->Restauration = new ArrayCollection();
        $this->ateliers = new ArrayCollection();
        $this->Chambres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Atelier>
     */
    public function getAteliers(): Collection
    {
        return $this->ateliers;
    }

    public function addAtelier(Atelier $atelier): self
    {
        if (!$this->ateliers->contains($atelier)) {
            $this->ateliers->add($atelier);
        }

        return $this;
    }

    public function removeAtelier(Atelier $atelier): self
    {
        $this->ateliers->removeElement($atelier);

        return $this;
    }

    /**
     * @return Collection<int, Chambre>
     */
    public function getChambres(): Collection
    {
        return $this->Chambres;
    }

    public function addChambre(Chambre $chambre): self
    {
        if (!$this->Chambres->contains($chambre)) {
            $this->Chambres->add($chambre);
        }

        return $this;
    }

    public function removeChambre(Chambre $chambre): self
    {
        $this->Chambres->removeElement($chambre);

        return $this;
    }

    public function isIsValidated(): ?bool
    {
        return $this->is_validated;
    }

    public function setIsValidated(bool $is_validated): self
    {
        $this->is_validated = $is_validated;

        return $this;
    }

}
