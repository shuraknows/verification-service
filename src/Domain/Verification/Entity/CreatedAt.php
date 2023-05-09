<?php

declare(strict_types=1);

namespace App\Domain\Verification\Entity;

use DateTimeImmutable;

final readonly class CreatedAt
{
    public function __construct(private DateTimeImmutable $createdAt)
    {
    }
}
