<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class IsValidArmorTrainingValidator extends ConstraintValidator
{
    public const ARMOR_TRAININGS = ['Light', 'Intermediate', 'Heavy', 'Shield'];

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof IsValidArmorTraining) {
            throw new UnexpectedTypeException($constraint, IsValidArmorTraining::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_array($value)) {
            if(!is_string($value)) {
                throw new UnexpectedValueException($value, 'string|array');
            }
        }

        $invalidArmorTrainings = [];

        if(is_string($value)) {
            if (!in_array($value, self::ARMOR_TRAININGS)) {
                $invalidArmorTrainings[]= $value;
            }
        }

        if(is_array($value)) {
            for ($i=0; $i < count($value); $i++) { 
                if (!in_array($value[$i], self::ARMOR_TRAININGS)) {
                    $invalidArmorTrainings[] = $value[$i];
                }
            }
        }

        if($invalidArmorTrainings == null) {
            return;
        }

        // the argument must be a string or an object implementing __toString()
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ armorTrainings }}', implode(', ', $invalidArmorTrainings))
            ->addViolation();
    }
}