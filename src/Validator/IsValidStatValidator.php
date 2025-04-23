<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class IsValidStatValidator extends ConstraintValidator
{
    public const STATS = ['Strength', 'Dexterity', 'Constitution', 'Wisdom', 'Intelligence', 'Charisma'];

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof IsValidStat) {
            throw new UnexpectedTypeException($constraint, IsValidStat::class);
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

        $invalidStats = [];

        if(is_string($value)) {
            if (!in_array($value, self::STATS)) {
                $invalidStats[]= $value;
            }
        }

        if(is_array($value)) {
            for ($i=0; $i < count($value); $i++) { 
                if (!in_array($value[$i], self::STATS)) {
                    $invalidStats[] = $value[$i];
                }
            }
        }

        if($invalidStats == null) {
            return;
        }

        // the argument must be a string or an object implementing __toString()
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ stats }}', implode(', ', $invalidStats))
            ->addViolation();
    }
}