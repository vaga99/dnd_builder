<?php

namespace App\Validator;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class IsValidArmorTraining extends Constraint
{
    public string $message = 'The following armor training(s) do(es) not exist : "{{ armorTrainings }}"';

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