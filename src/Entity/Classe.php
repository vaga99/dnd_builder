<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
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

    #[ORM\Column(type: Types::ARRAY)]
    private array $saving_throw_proficiencies = [];

    #[ORM\Column(type: Types::ARRAY)]
    private array $weapon_proficiencies = [];

    #[ORM\Column(type: Types::ARRAY)]
    private array $skill_proficiencies = [];

    #[ORM\Column(type: Types::ARRAY)]
    private array $armor_training = [];

    #[ORM\Column(type: Types::TEXT)]
    private ?string $starting_equipment = null;

    #[ORM\Column(length: 255)]
    private ?string $primary_ability = null;

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

    public function getArmorTraining(): array
    {
        return $this->armor_training;
    }

    public function setArmorTraining(array $armor_training): static
    {
        $this->armor_training = $armor_training;

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

    public function getPrimaryAbility(): ?string
    {
        return $this->primary_ability;
    }

    public function setPrimaryAbility(string $primary_ability): static
    {
        $this->primary_ability = $primary_ability;

        return $this;
    }
}
