<?php

namespace App\Entity;

use App\Repository\StatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatRepository::class)]
class Stat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $but = null;

    #[ORM\Column]
    private ?int $assist = null;

    #[ORM\Column]
    private ?int $cartonrouge = null;

    #[ORM\Column]
    private ?int $cartonjaune = null;

    #[ORM\Column]
    private ?int $minutejoue = null;

    #[ORM\Column]
    private ?float $note = null;

    #[ORM\ManyToOne(inversedBy: 'stats')]
    private ?Joueur $Joueur = null;

    #[ORM\ManyToOne(inversedBy: 'stats')]
    private ?Game $Game = null;

    #[ORM\Column(length: 255)]
    private ?string $lien = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBut(): ?int
    {
        return $this->but;
    }

    public function setBut(int $but): static
    {
        $this->but = $but;

        return $this;
    }

    public function getAssist(): ?int
    {
        return $this->assist;
    }

    public function setAssist(int $assist): static
    {
        $this->assist = $assist;

        return $this;
    }

    public function getCartonrouge(): ?int
    {
        return $this->cartonrouge;
    }

    public function setCartonrouge(int $cartonrouge): static
    {
        $this->cartonrouge = $cartonrouge;

        return $this;
    }

    public function getCartonjaune(): ?int
    {
        return $this->cartonjaune;
    }

    public function setCartonjaune(int $cartonjaune): static
    {
        $this->cartonjaune = $cartonjaune;

        return $this;
    }

    public function getMinutejoue(): ?int
    {
        return $this->minutejoue;
    }

    public function setMinutejoue(int $minutejoue): static
    {
        $this->minutejoue = $minutejoue;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getJoueur(): ?Joueur
    {
        return $this->Joueur;
    }

    public function setJoueur(?Joueur $Joueur): static
    {
        $this->Joueur = $Joueur;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->Game;
    }

    public function setGame(?Game $Game): static
    {
        $this->Game = $Game;

        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): static
    {
        $this->lien = $lien;

        return $this;
    }
}
