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
                    '6',
                    '8',
                    '10',
                    '12'
                ]
            ])
            ->add('savingThrowProficiencies', ChoiceType::class, [
                'choices' => [
                    'Strength', 
                    'Dexterity', 
                    'Constitution', 
                    'Wisdom', 
                    'Intelligence', 
                    'Charisma'
                ],
                'multiple' => true,
            ])
            ->add('weaponProficiencies', ChoiceType::class, [
                'choices' => [
                    'Simple', 
                    'Martial'
                ],
                'multiple' => true,
            ])
            ->add('skillProficiencies', ChoiceType::class, [
                'choices' => [
                    'Athletics',
                    'Acrobatics',
                    'Sleight of Hand',
                    'Stealth',
                    'Arcana',
                    'History',
                    'Investigation',
                    'Nature',
                    'Religion',
                    'Animal Handling',
                    'Insight',
                    'Medicine',
                    'Perception',
                    'Survival',
                    'Deception',
                    'Intimidation',
                    'Performance',
                    'Persuasion'
                ],
                'multiple' => true,
            ])
            ->add('startingEquipment', TextType::class)
            ->add('primaryAbility', ChoiceType::class, [
                'choices' => [
                    'Strength', 
                    'Dexterity', 
                    'Constitution', 
                    'Wisdom', 
                    'Intelligence', 
                    'Charisma'
                ],
                'multiple' => true,
            ])
            ->add('armorTraining', ChoiceType::class, [
                'choices' => [
                    'Light', 
                    'Intermediate', 
                    'Heavy', 
                    'Shield'
                ],
                'multiple' => true,
            ])
            ->add('tool_proficiencies', ChoiceType::class, [
                'choices' => [
                    "Brewer's supplies", 
                    "Calligrapher's supplies", 
                    "Dice set", 
                    "Drum"
                ],
                'multiple' => true,
            ])
            ->add('save', SubmitType::class)
        ;
    }
}