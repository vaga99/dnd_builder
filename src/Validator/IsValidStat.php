<?php

namespace App\Validator;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class IsValidStat extends Constraint
{
    public string $message = 'The following stat(s) do(es) not exist : "{{ stats }}"';

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