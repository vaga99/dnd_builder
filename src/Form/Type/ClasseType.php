<?php

namespace App\Form\Type\ClasseType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class ClasseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('hitPointDie', ChoiceType::class, [
                'choices' => [
                    'D6' => '6',
                    'D8' => '8',
                    'D10' => '10',
                    'D12' => '12'
                ]
            ])
            ->add('savingThrowProficiencies', ChoiceType::class, [
                'choices' => [
                    'Strength' => 'Strength', 
                    'Dexterity' => 'Dexterity', 
                    'Constitution' => 'Constitution', 
                    'Wisdom' => 'Wisdom', 
                    'Intelligence' => 'Intelligence', 
                    'Charisma' => 'Charisma'
                ],
                'multiple' => true,
            ])
            ->add('weaponProficiencies', ChoiceType::class, [
                'choices' => [
                    'Simple' => 'Simple', 
                    'Martial' => 'Martial'
                ],
                'multiple' => true,
            ])
            ->add('skillProficiencies', ChoiceType::class, [
                'choices' => [
                    'Athletics' => 'Athletics',
                    'Acrobatics' => 'Acrobatics',
                    'Sleight of Hand' => 'Sleight of Hand',
                    'Stealth' => 'Stealth',
                    'Arcana' => 'Arcana',
                    'History' => 'History',
                    'Investigation' => 'Investigation',
                    'Nature' => 'Nature',
                    'Religion' => 'Religion',
                    'Animal Handling' => 'Animal Handling',
                    'Insight' => 'Insight',
                    'Medicine' => 'Medicine',
                    'Perception' => 'Perception',
                    'Survival' => 'Survival',
                    'Deception' => 'Deception',
                    'Intimidation' => 'Intimidation',
                    'Performance' => 'Performance',
                    'Persuasion' => 'Persuasion'
                ],
                'multiple' => true,
            ])
            ->add('startingEquipment', TextType::class)
            ->add('primaryAbility', ChoiceType::class, [
                'choices' => [
                    'Strength' => 'Strength', 
                    'Dexterity' => 'Dexterity', 
                    'Constitution' => 'Constitution', 
                    'Wisdom' => 'Wisdom', 
                    'Intelligence' => 'Intelligence', 
                    'Charisma' => 'Charisma'
                ],
                'multiple' => true,
            ])
            ->add('armorTraining', ChoiceType::class, [
                'choices' => [
                    'Light' => 'Light', 
                    'Intermediate' => 'Intermediate', 
                    'Heavy' => 'Heavy', 
                    'Shield' => 'Shield'
                ],
                'multiple' => true,
            ])
            ->add('tool_proficiencies', ChoiceType::class, [
                'choices' => [
                    "Brewer's supplies" => "Brewer's supplies", 
                    "Calligrapher's supplies" => "Calligrapher's supplies", 
                    "Dice set" => "Dice set", 
                    "Drum" => "Drum"
                ],
                'multiple' => true,
            ])
            ->add('save', SubmitType::class)
        ;
    }
}