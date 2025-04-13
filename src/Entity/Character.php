<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: '`character`')]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[GROUPS(["getClasses"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[GROUPS(["getClasses"])]
    private ?string $name = null;

    #[ORM\Column]
    #[GROUPS(["getClasses"])]
    private array $stats = [];

    #[ORM\Column]
    #[GROUPS(["getClasses"])]
    private ?int $level = null;

    #[ORM\Column(length: 255)]
    private ?string $species = null;

    /**
     * @var Collection<int, Classe>
     */
    #[ORM\ManyToMany(targetEntity: Classe::class, inversedBy: 'characters')]
    private Collection $Classes;

    public function __construct()
    {
        $this->Classes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getStats(): array
    {
        return $this->stats;
    }

    public function setStats(array $stats): static
    {
        $this->stats = $stats;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getSpecies(): ?string
    {
        return $this->species;
    }

    public function setSpecies(string $species): static
    {
        $this->species = $species;

        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getClasses(): Collection
    {
        return $this->Classes;
    }

    public function addClasse(Classe $classe): static
    {
        if (!$this->Classes->contains($classe)) {
            $this->Classes->add($classe);
        }

        return $this;
    }

    public function removeClasse(Classe $classe): static
    {
        $this->Classes->removeElement($classe);

        return $this;
    }
}
