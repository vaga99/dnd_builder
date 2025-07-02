<?php

namespace App\Form\Type\CharacterType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)

            ->add('level', NumberType::class, [
                'attr' => [
                    'min' => '1',
                    'max' => '20',
                ]
            ])
            ->add('species', TextType::class)
            ->add('save', SubmitType::class)
        ;
    }
}