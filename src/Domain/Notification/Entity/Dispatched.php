<?php

declare(strict_types=1);

namespace App\Domain\Notification\Entity;

final class Dispatched
{
    public function __construct(private bool $dispatched)
    {
    }

    public function markAsDispatched(): void
    {
        $this->dispatched = true;
    }

    public function isDispatched(): bool
    {
        return $this->dispatched;
    }
}
