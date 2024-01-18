<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomcategory = null;

    #[ORM\OneToMany(mappedBy: 'Category', targetEntity: Joueur::class)]
    private Collection $joueurs;

    #[ORM\OneToMany(mappedBy: 'Category', targetEntity: Game::class)]
    private Collection $games;

    #[ORM\ManyToMany(targetEntity: Equipe::class, inversedBy: 'categories')]
    private Collection $Equipe;

    public function __construct()
    {
        $this->joueurs = new ArrayCollection();
        $this->games = new ArrayCollection();
        $this->Equipe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomcategory(): ?string
    {
        return $this->nomcategory;
    }

    public function setNomcategory(string $nomcategory): static
    {
        $this->nomcategory = $nomcategory;

        return $this;
    }

    /**
     * @return Collection<int, Joueur>
     */
    public function getJoueurs(): Collection
    {
        return $this->joueurs;
    }

    public function addJoueur(Joueur $joueur): static
    {
        if (!$this->joueurs->contains($joueur)) {
            $this->joueurs->add($joueur);
            $joueur->setCategory($this);
        }

        return $this;
    }

    public function removeJoueur(Joueur $joueur): static
    {
        if ($this->joueurs->removeElement($joueur)) {
            // set the owning side to null (unless already changed)
            if ($joueur->getCategory() === $this) {
                $joueur->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): static
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
            $game->setCategory($this);
        }

        return $this;
    }

    public function removeGame(Game $game): static
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getCategory() === $this) {
                $game->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Equipe>
     */
    public function getEquipe(): Collection
    {
        return $this->Equipe;
    }

    public function addEquipe(Equipe $equipe): static
    {
        if (!$this->Equipe->contains($equipe)) {
            $this->Equipe->add($equipe);
        }

        return $this;
    }

    public function removeEquipe(Equipe $equipe): static
    {
        $this->Equipe->removeElement($equipe);

        return $this;
    }
}
