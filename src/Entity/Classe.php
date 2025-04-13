<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
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
    private ?int $hitPointDie = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    #[GROUPS(["getClasses"])]
    private array $savingThrowProficiencies = [];

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    #[GROUPS(["getClasses"])]
    private array $weaponProficiencies = [];

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    #[GROUPS(["getClasses"])]
    private array $skillProficiencies = [];

    #[ORM\Column(type: Types::TEXT)]
    #[GROUPS(["getClasses"])]
    private ?string $startingEquipment = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    #[GROUPS(["getClasses"])]
    private array $primaryAbility = [];

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    #[GROUPS(["getClasses"])]
    private ?array $armorTraining = null;

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
        return $this->hitPointDie;
    }

    public function setHitPointDie(int $hitPointDie): static
    {
        $this->hitPointDie = $hitPointDie;

        return $this;
    }

    public function getSavingThrowProficiencies(): array
    {
        return $this->savingThrowProficiencies;
    }

    public function setSavingThrowProficiencies(array $savingThrowProficiencies): static
    {
        $this->savingThrowProficiencies = $savingThrowProficiencies;

        return $this;
    }

    public function getWeaponProficiencies(): array
    {
        return $this->weaponProficiencies;
    }

    public function setWeaponProficiencies(array $weaponProficiencies): static
    {
        $this->weaponProficiencies = $weaponProficiencies;

        return $this;
    }

    public function getSkillProficiencies(): array
    {
        return $this->skillProficiencies;
    }

    public function setSkillProficiencies(array $skillProficiencies): static
    {
        $this->skillProficiencies = $skillProficiencies;

        return $this;
    }

    public function getStartingEquipment(): ?string
    {
        return $this->startingEquipment;
    }

    public function setStartingEquipment(string $startingEquipment): static
    {
        $this->startingEquipment = $startingEquipment;

        return $this;
    }

    public function getPrimaryAbility(): ?array
    {
        return $this->primaryAbility;
    }

    public function setPrimaryAbility(array $primaryAbility): static
    {
        $this->primaryAbility = $primaryAbility;

        return $this;
    }

    public function getArmorTraining(): ?array
    {
        return $this->armorTraining;
    }

    public function setArmorTraining(?array $armorTraining): static
    {
        $this->armorTraining = $armorTraining;

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
}
