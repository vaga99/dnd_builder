<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class IsValidSkillValidator extends ConstraintValidator
{
    public const SKILLS = ['Athletics','Acrobatics','Sleight of Hand','Stealth','Arcana','History','Investigation','Nature','Religion','Animal Handling','Insight','Medicine','Perception','Survival','Deception','Intimidation','Performance','Persuasion'];

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof IsValidSKill) {
            throw new UnexpectedTypeException($constraint, IsValidSKill::class);
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

        $invalidSkills = [];

        if(is_string($value)) {
            if (!in_array($value, self::SKILLS)) {
                $invalidSkills[]= $value;
            }
        }

        if(is_array($value)) {
            for ($i=0; $i < count($value); $i++) { 
                if (!in_array($value[$i], self::SKILLS)) {
                    $invalidSkills[] = $value[$i];
                }
            }
        }

        if($invalidSkills == null) {
            return;
        }

        // the argument must be a string or an object implementing __toString()
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ skills }}', implode(', ', $invalidSkills))
            ->addViolation();
    }
}