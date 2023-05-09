<?php

declare(strict_types=1);

namespace App\Domain\Verification\Entity\Subject;

use App\Domain\Verification\Exception\Subject\InvalidIdentityException;

final readonly class Identity
{
    public function __construct(private string $identity)
    {
        if (0 === strlen($this->identity)) {
            throw new InvalidIdentityException();
        }
    }

    public function identity(): string
    {
        return $this->identity;
    }

    public function __toString(): string
    {
        return $this->identity;
    }
}
