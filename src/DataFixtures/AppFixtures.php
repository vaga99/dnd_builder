<?php

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\Classe;
use App\Entity\Test;
use App\Repository\ClasseRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $fighter = new Classe();
        $fighter->setName("Fighter");
        $fighter->setHitPointDie("10");
        $fighter->setPrimaryAbility(["Strength", "Dexterity"]);
        $fighter->setSavingThrowProficiencies(["Strength", "Constitution"]);
        $fighter->setSkillProficiencies(["Acrobatics", "Animal Handling", "Athletics", "History", "Insight", "Intimidation", "Persuasion", "Perception", "Survival"]);
        $fighter->setWeaponProficiencies(["Simple", "Martial"]);
        $fighter->setArmorTraining(["Light", "Medium", "Heavy", "Shield"]);
        $fighter->setStartingEquipment("Choose A, B, or C: (A) Chain Mail, Greatsword, Flail, 8 Javelins, Dungeoneer’s Pack, and 4 GP; (B) Studded Leather Armor, Scimitar, Shortsword, Longbow, 20 Arrows, Quiver, Dungeoneer’s Pack, and 11 GP; or (C) 155 GP");
        $manager->persist($fighter);

        $wizard = new Classe();
        $wizard->setName("Wizard");
        $wizard->setHitPointDie("6");
        $wizard->setPrimaryAbility(["Intelligence"]);
        $wizard->setSavingThrowProficiencies(["Intelligence", "Wisdom"]);
        $wizard->setSkillProficiencies(["Arcana", "History", "Insight", "Investigation", "Medicine", "Nature", "Religion"]);
        $wizard->setWeaponProficiencies(["Simple"]);
        $wizard->setStartingEquipment("Choose A or B: (A) 2 Daggers, Arcane Focus (Quarterstaff), Robe, Spellbook, Scholar’s Pack, and 5 GP; or (B) 55 GP");
        $manager->persist($wizard);

        $rogue = new Classe();
        $rogue->setName("Rogue");
        $rogue->setHitPointDie("8");
        $rogue->setPrimaryAbility(["Dexterity"]);
        $rogue->setSavingThrowProficiencies(["Intelligence", "Dexterity"]);
        $rogue->setSkillProficiencies(["Acrobatics", "Athletics", "Deception", "Insight", "Intimidation", "Investigation", "Perception", "Persuasion", "Sleight of Hand", "Stealth"]);
        $rogue->setWeaponProficiencies(["Simple", "Martial F/L"]);
        $rogue->setArmorTraining(["Light"]);
        $rogue->setToolProficiencies(["Thieves’ Tools"]);
        $rogue->setStartingEquipment("Choose A or B: (A) Leather Armor, 2 Daggers, Shortsword, Shortbow, 20 Arrows, Quiver, Thieves’ Tools, Burglar’s Pack, and 8 GP; or (B) 100 GP");
        $manager->persist($rogue);

        $character1 = new Character();
        $character1->setName("Billy");
        $character1->setSpecies("Human");
        $character1->setStats(
            [
                'Strength' => 17,
                'Dexterity' => 16,
                'Constitution' => 15,
                'Wisdom' => 8,
                'Intelligence' => 8,
                'Charisma' => 8,
            ]
        );
        $character1->setLevel(3);
        $character1->addClasse($fighter);

        $character1 = new Character();
        $character1->setName("Billy");
        $character1->setSpecies("Human");
        $character1->setStats(
            [
                'Strength' => 17,
                'Dexterity' => 16,
                'Constitution' => 15,
                'Wisdom' => 8,
                'Intelligence' => 8,
                'Charisma' => 8,
            ]
        );
        $character1->setLevel(3);
        $character1->addClasse($fighter);

        $manager->persist($character1);

        $character2 = new Character();
        $character2->setName("Oz");
        $character2->setSpecies("Elf");
        $character2->setStats(
            [
                'Strength' => 8,
                'Dexterity' => 8,
                'Constitution' => 16,
                'Wisdom' => 8,
                'Intelligence' => 17,
                'Charisma' => 15,
            ]
        );
        $character2->setLevel(5);
        $character2->addClasse($wizard);
        
        $manager->persist($character2);

        $character3 = new Character();
        $character3->setName("Lupin 3");
        $character3->setSpecies("Dwarf");
        $character3->setStats(
            [
                'Strength' => 8,
                'Dexterity' => 17,
                'Constitution' => 16,
                'Wisdom' => 8,
                'Intelligence' => 8,
                'Charisma' => 15,
            ]
        );
        $character3->setLevel(2);
        $character3->addClasse($rogue);
        
        $manager->persist($character3);

        $manager->flush();
    }
}
