<?php

namespace App\Entity;

use App\Repository\VacationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VacationRepository::class)]
class Vacation
{   
    public function __construct()
{
    $this->date = new \DateTime('now');
}

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateheureDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateheureFin = null;

    #[ORM\ManyToOne(inversedBy: 'vacations')]
    private ?Atelier $atelier = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateheureDebut(): ?\DateTimeInterface
    {
        return $this->dateheureDebut;
    }

    public function setDateheureDebut(\DateTimeInterface $dateheureDebut): self
    {
        $this->dateheureDebut = $dateheureDebut;

        return $this;
    }

    public function getDateheureFin(): ?\DateTimeInterface
    {
        return $this->dateheureFin;
    }

    public function setDateheureFin(\DateTimeInterface $dateheureFin): self
    {
        $this->dateheureFin = $dateheureFin;

        return $this;
    }

    public function getAtelier(): ?Atelier
    {
        return $this->atelier;
    }

    public function setAtelier(?Atelier $atelier): self
    {
        $this->atelier = $atelier;

        return $this;
    }
    
 
}
