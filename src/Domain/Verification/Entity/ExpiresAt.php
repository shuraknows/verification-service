<?php

declare(strict_types=1);

namespace App\Domain\Verification\Entity;

use DateTimeImmutable;

final readonly class ExpiresAt
{
    public function __construct(private DateTimeImmutable $expiresAt)
    {
    }

    public function expired(DateTimeImmutable $now = null): bool
    {
        return $this->expiresAt < $now;
    }
}
