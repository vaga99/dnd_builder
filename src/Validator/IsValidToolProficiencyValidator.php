<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class IsValidToolProficiencyValidator extends ConstraintValidator
{
    public const TOOL_PROFICIENCIES = ["Brewer's supplies", "Calligrapher's supplies", "Dice set", "Drum"];

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof IsValidToolProficiency) {
            throw new UnexpectedTypeException($constraint, IsValidToolProficiency::class);
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

        $invalidToolProficiencies = [];

        if(is_string($value)) {
            if (!in_array($value, self::TOOL_PROFICIENCIES)) {
                $invalidToolProficiencies[]= $value;
            }
        }

        if(is_array($value)) {
            for ($i=0; $i < count($value); $i++) { 
                if (!in_array($value[$i], self::TOOL_PROFICIENCIES)) {
                    $invalidToolProficiencies[] = $value[$i];
                }
            }
        }

        if($invalidToolProficiencies == null) {
            return;
        }

        // the argument must be a string or an object implementing __toString()
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ toolProficiencies }}', implode(', ', $invalidToolProficiencies))
            ->addViolation();
    }
}