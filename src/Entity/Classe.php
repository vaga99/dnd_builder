<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $hit_point_die = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $saving_throw_proficiencies = [];

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $weapon_proficiencies = [];

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $skill_proficiencies = [];

    #[ORM\Column(type: Types::TEXT)]
    private ?string $starting_equipment = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $primary_ability = [];

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    private ?array $armor_training = null;

    /**
     * @var Collection<int, Character>
     */
    #[ORM\ManyToMany(targetEntity: Character::class, mappedBy: 'Classes')]
    private Collection $characters;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    private ?array $tool_proficiencies = null;
    
    public function __construct()
    {
        $this->characters = new ArrayCollection();
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

    public function getHitPointDie(): ?int
    {
        return $this->hit_point_die;
    }

    public function setHitPointDie(int $hit_point_die): static
    {
        $this->hit_point_die = $hit_point_die;

        return $this;
    }

    public function getSavingThrowProficiencies(): array
    {
        return $this->saving_throw_proficiencies;
    }

    public function setSavingThrowProficiencies(array $saving_throw_proficiencies): static
    {
        $this->saving_throw_proficiencies = $saving_throw_proficiencies;

        return $this;
    }

    public function getWeaponProficiencies(): array
    {
        return $this->weapon_proficiencies;
    }

    public function setWeaponProficiencies(array $weapon_proficiencies): static
    {
        $this->weapon_proficiencies = $weapon_proficiencies;

        return $this;
    }

    public function getSkillProficiencies(): array
    {
        return $this->skill_proficiencies;
    }

    public function setSkillProficiencies(array $skill_proficiencies): static
    {
        $this->skill_proficiencies = $skill_proficiencies;

        return $this;
    }

    public function getStartingEquipment(): ?string
    {
        return $this->starting_equipment;
    }

    public function setStartingEquipment(string $starting_equipment): static
    {
        $this->starting_equipment = $starting_equipment;

        return $this;
    }

    public function getPrimaryAbility(): ?array
    {
        return $this->primary_ability;
    }

    public function setPrimaryAbility(array $primary_ability): static
    {
        $this->primary_ability = $primary_ability;

        return $this;
    }

    public function getArmorTraining(): ?array
    {
        return $this->armor_training;
    }

    public function setArmorTraining(?array $armor_training): static
    {
        $this->armor_training = $armor_training;

        return $this;
    }

    /**
     * @return Collection<int, Character>
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(Character $character): static
    {
        if (!$this->characters->contains($character)) {
            $this->characters->add($character);
            $character->addClasse($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): static
    {
        if ($this->characters->removeElement($character)) {
            $character->removeClasse($this);
        }

        return $this;
    }

    public function getToolProficiencies(): ?array
    {
        return $this->tool_proficiencies;
    }

    public function setToolProficiencies(?array $tool_proficiencies): static
    {
        $this->tool_proficiencies = $tool_proficiencies;

        return $this;
    }
}
