<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\Test;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=0; $i <20; $i++) { 
            $test = new Test();
            $test->setName('name '.$i);
            $manager->persist($test);
        }

        $fighter = new Classe();
        $fighter->setName("Fighter");
        $fighter->setHitPointDie("10");
        $fighter->setPrimaryAbility(["Strength", "Dexterity"]);
        $fighter->setSavingThrowProficiencies(["Strength", "Constitution"]);
        $fighter->setSkillProficiencies(["Acrobatics", "Animal Handling", "Athletics", "History", "Insight", "Intimidation", "Persuasion", "Perception", "Survival"]);
        $fighter->setWeaponProficiencies(["Simple", "Martial weapons"]);
        $fighter->setArmorTraining(["Light", "Medium", "Heavy", "Shield"]);
        $fighter->setStartingEquipment("Choose A, B, or C: (A) Chain Mail, Greatsword, Flail, 8 Javelins, Dungeoneer’s Pack, and 4 GP; (B) Studded Leather Armor, Scimitar, Shortsword, Longbow, 20 Arrows, Quiver, Dungeoneer’s Pack, and 11 GP; or (C) 155 GP");
        $manager->persist($fighter);

        $manager->flush();
    }
}
