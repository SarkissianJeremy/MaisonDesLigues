<?php

namespace App\Entity;

use App\Repository\AtelierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AtelierRepository::class)]
class Atelier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?int $nbPlacesMaxi = null;

    #[ORM\ManyToMany(targetEntity: Inscription::class, mappedBy: 'Atelier')]
    private Collection $inscriptions;

    #[ORM\OneToMany(mappedBy: 'atelier', targetEntity: Theme::class)]
    private Collection $Themes;

    #[ORM\ManyToMany(targetEntity: Inscription::class, inversedBy: 'ateliers')]
    private Collection $Inscriptions;

    #[ORM\OneToMany(mappedBy: 'atelier', targetEntity: Vacation::class)]
    private Collection $vacations;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
        $this->Themes = new ArrayCollection();
        $this->Inscriptions = new ArrayCollection();
        $this->vacations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getNbPlacesMaxi(): ?int
    {
        return $this->nbPlacesMaxi;
    }

    public function setNbPlacesMaxi(int $nbPlacesMaxi): self
    {
        $this->nbPlacesMaxi = $nbPlacesMaxi;

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions->add($inscription);
            $inscription->addAtelier($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            $inscription->removeAtelier($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Theme>
     */
    public function getThemes(): Collection
    {
        return $this->Themes;
    }

    public function addTheme(Theme $theme): self
    {
        if (!$this->Themes->contains($theme)) {
            $this->Themes->add($theme);
            $theme->setAtelier($this);
        }

        return $this;
    }

    public function removeTheme(Theme $theme): self
    {
        if ($this->Themes->removeElement($theme)) {
            // set the owning side to null (unless already changed)
            if ($theme->getAtelier() === $this) {
                $theme->setAtelier(null);
            }
        }

        return $this;
    }
    
    public function __toString() {
        return $this->libelle;
    }

    /**
     * @return Collection<int, Vacation>
     */
    public function getVacations(): Collection
    {
        return $this->vacations;
    }

    public function addVacation(Vacation $vacation): self
    {
        if (!$this->vacations->contains($vacation)) {
            $this->vacations->add($vacation);
            $vacation->setAtelier($this);
        }

        return $this;
    }

    public function removeVacation(Vacation $vacation): self
    {
        if ($this->vacations->removeElement($vacation)) {
            // set the owning side to null (unless already changed)
            if ($vacation->getAtelier() === $this) {
                $vacation->setAtelier(null);
            }
        }

        return $this;
    }
}
