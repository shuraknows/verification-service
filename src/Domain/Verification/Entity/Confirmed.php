<?php

declare(strict_types=1);

namespace App\Domain\Verification\Entity;

final class Confirmed
{
    public function __construct(private bool $confirmed)
    {
    }

    public function confirmed(): bool
    {
        return $this->confirmed;
    }
}
