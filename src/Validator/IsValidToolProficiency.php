<?php

namespace App\Validator;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class IsValidToolProficiency extends Constraint
{
    public string $message = 'The following tool proficiencies do(es) not exist : "{{ toolProficiencies }}"';

    #[HasNamedArguments]
    public function __construct(
        private string $mode,
        ?array $groups = null,
        mixed $payload = null,
    ) {
        parent::__construct([], $groups, $payload);
    }

    public function __sleep(): array
    {
        return array_merge(
            parent::__sleep(),
            [
                'mode'
            ]
        );
    }
}