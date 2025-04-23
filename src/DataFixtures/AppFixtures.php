<?php

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\CharacterClasse;
use App\Entity\Classe;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Config\DoctrineConfig;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher) {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $em): void
    {

        // Création d'un utilisateur joueur
        $userPlayer = new User();
        $userPlayer->setEmail("player@mail.com");
        $userPlayer->setRoles(["ROLE_PLAYER"]);
        $userPlayer->setPassword($this->userPasswordHasher->hashPassword($userPlayer, 'passwordPlayer'));
        $em->persist($userPlayer);

        // Création d'un utilisateur maitre du jeu (donjon master ou DM)
        $userDM = new User();
        $userDM->setEmail("dm@mail.com");
        $userDM->setRoles(["ROLE_DM"]);
        $userDM->setPassword($this->userPasswordHasher->hashPassword($userDM, 'passwordDM'));
        $em->persist($userDM);

        // Création d'un utilisateur admin
        $userAdmin = new User();
        $userAdmin->setEmail("admin@mail.com");
        $userAdmin->setRoles(["ROLE_ADMIN"]);
        $userAdmin->setPassword($this->userPasswordHasher->hashPassword($userAdmin, 'passwordAdmin'));
        $em->persist($userAdmin);

        $fighter = new Classe();
        $fighter->setName("Fighter");
        $fighter->setHitPointDie("10");
        $fighter->setPrimaryAbility(["Strength", "Dexterity"]);
        $fighter->setSavingThrowProficiencies(["Strength", "Constitution"]);
        $fighter->setSkillProficiencies(["Acrobatics", "Animal Handling", "Athletics", "History", "Insight", "Intimidation", "Persuasion", "Perception", "Survival"]);
        $fighter->setWeaponProficiencies(["Simple", "Martial"]);
        $fighter->setArmorTraining(["Light", "Medium", "Heavy", "Shield"]);
        $fighter->setStartingEquipment("Choose A, B, or C: (A) Chain Mail, Greatsword, Flail, 8 Javelins, Dungeoneer’s Pack, and 4 GP; (B) Studded Leather Armor, Scimitar, Shortsword, Longbow, 20 Arrows, Quiver, Dungeoneer’s Pack, and 11 GP; or (C) 155 GP");
        $em->persist($fighter);

        $wizard = new Classe();
        $wizard->setName("Wizard");
        $wizard->setHitPointDie("6");
        $wizard->setPrimaryAbility(["Intelligence"]);
        $wizard->setSavingThrowProficiencies(["Intelligence", "Wisdom"]);
        $wizard->setSkillProficiencies(["Arcana", "History", "Insight", "Investigation", "Medicine", "Nature", "Religion"]);
        $wizard->setWeaponProficiencies(["Simple"]);
        $wizard->setStartingEquipment("Choose A or B: (A) 2 Daggers, Arcane Focus (Quarterstaff), Robe, Spellbook, Scholar’s Pack, and 5 GP; or (B) 55 GP");
        $em->persist($wizard);

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
        $em->persist($rogue);

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
        $em->persist($character1);

        $characterClasse1 = new CharacterClasse();
        $characterClasse1->setClasse($fighter);
        $characterClasse1->setCharacter($character1);
        $characterClasse1->setLevel(3);
        $em->persist($characterClasse1);

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
        $em->persist($character2);

        $characterClasse2 = new CharacterClasse();
        $characterClasse2->setClasse($wizard);
        $characterClasse2->setCharacter($character2);
        $characterClasse2->setLevel(5);
        $em->persist($characterClasse2);

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
        $em->persist($character3);

        $characterClasse3 = new CharacterClasse();
        $characterClasse3->setClasse($fighter);
        $characterClasse3->setCharacter($character3);
        $characterClasse3->setLevel(2);
        $em->persist($characterClasse3);

        $em->flush();
    }
}
