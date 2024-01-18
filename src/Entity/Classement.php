<?php

namespace App\Entity;

use App\Repository\ClassementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassementRepository::class)]
class Classement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nbrm = null;

    #[ORM\Column]
    private ?int $nbrmg = null;

    #[ORM\Column]
    private ?int $nbrmp = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Equipe $Equipe = null;

    #[ORM\Column]
    private ?int $nbrmn = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrm(): ?int
    {
        return $this->nbrm;
    }

    public function setNbrm(int $nbrm): static
    {
        $this->nbrm = $nbrm;

        return $this;
    }

    public function getNbrmg(): ?int
    {
        return $this->nbrmg;
    }

    public function setNbrmg(int $nbrmg): static
    {
        $this->nbrmg = $nbrmg;

        return $this;
    }

    public function getNbrmp(): ?int
    {
        return $this->nbrmp;
    }

    public function setNbrmp(int $nbrmp): static
    {
        $this->nbrmp = $nbrmp;

        return $this;
    }

    public function getEquipe(): ?Equipe
    {
        return $this->Equipe;
    }

    public function setEquipe(?Equipe $Equipe): static
    {
        $this->Equipe = $Equipe;

        return $this;
    }

    public function getNbrmn(): ?int
    {
        return $this->nbrmn;
    }

    public function setNbrmn(int $nbrmn): static
    {
        $this->nbrmn = $nbrmn;

        return $this;
    }
}
