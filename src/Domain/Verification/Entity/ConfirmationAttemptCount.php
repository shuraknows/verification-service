<?php

declare(strict_types=1);

namespace App\Domain\Verification\Entity;

final class ConfirmationAttemptCount
{
    public function __construct(private int $confirmationAttemptCount = 0)
    {
    }

    public function increase(): void
    {
        $this->confirmationAttemptCount++;
    }

    public function reached(int $maxAttemptCount): bool
    {
        return $this->confirmationAttemptCount >= $maxAttemptCount;
    }
}
