<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datedumatch = null;

    #[ORM\Column(length: 255)]
    private ?string $stade = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Equipe $equipe1 = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Equipe $equipe2 = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    private ?Category $Category = null;

    #[ORM\OneToMany(mappedBy: 'Game', targetEntity: Stat::class)]
    private Collection $stats;

    #[ORM\Column(length: 255)]
    private ?string $lien = null;

    #[ORM\Column(nullable: true)]
    private ?int $score1 = null;

    #[ORM\Column(nullable: true)]
    private ?int $score2 = null;

    public function __construct()
    {
        $this->stats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatedumatch(): ?\DateTimeInterface
    {
        return $this->datedumatch;
    }

    public function setDatedumatch(\DateTimeInterface $datedumatch): static
    {
        $this->datedumatch = $datedumatch;

        return $this;
    }

    public function getStade(): ?string
    {
        return $this->stade;
    }

    public function setStade(string $stade): static
    {
        $this->stade = $stade;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getEquipe1(): ?equipe
    {
        return $this->equipe1;
    }

    public function setEquipe1(?equipe $equipe1): static
    {
        $this->equipe1 = $equipe1;

        return $this;
    }

    public function getEquipe2(): ?equipe
    {
        return $this->equipe2;
    }

    public function setEquipe2(?equipe $equipe2): static
    {
        $this->equipe2 = $equipe2;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): static
    {
        $this->Category = $Category;

        return $this;
    }

    /**
     * @return Collection<int, Stat>
     */
    public function getStats(): Collection
    {
        return $this->stats;
    }

    public function addStat(Stat $stat): static
    {
        if (!$this->stats->contains($stat)) {
            $this->stats->add($stat);
            $stat->setGame($this);
        }

        return $this;
    }

    public function removeStat(Stat $stat): static
    {
        if ($this->stats->removeElement($stat)) {
            // set the owning side to null (unless already changed)
            if ($stat->getGame() === $this) {
                $stat->setGame(null);
            }
        }

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

    public function getScore1(): ?int
    {
        return $this->score1;
    }

    public function setScore1(?int $score1): static
    {
        $this->score1 = $score1;

        return $this;
    }

    public function getScore2(): ?int
    {
        return $this->score2;
    }

    public function setScore2(?int $score2): static
    {
        $this->score2 = $score2;

        return $this;
    }
}
