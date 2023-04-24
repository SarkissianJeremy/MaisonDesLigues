<?php

namespace App\Entity;

use App\Repository\QualiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QualiteRepository::class)]
class Qualite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $libellequalite = null;

    #[ORM\OneToMany(mappedBy: 'idqualite', targetEntity: Licencie::class)]
    private Collection $licencies;

    public function __construct()
    {
        $this->licencies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibellequalite(): ?string
    {
        return $this->libellequalite;
    }

    public function setLibellequalite(string $libellequalite): self
    {
        $this->libellequalite = $libellequalite;

        return $this;
    }

    /**
     * @return Collection<int, Licencie>
     */
    public function getLicencies(): Collection
    {
        return $this->licencies;
    }

    public function addLicency(Licencie $licency): self
    {
        if (!$this->licencies->contains($licency)) {
            $this->licencies->add($licency);
            $licency->setQualite($this);
        }

        return $this;
    }

    public function removeLicency(Licencie $licency): self
    {
        if ($this->licencies->removeElement($licency)) {
            // set the owning side to null (unless already changed)
            if ($licency->getQualite() === $this) {
                $licency->setQualite(null);
            }
        }

        return $this;
    }
}
