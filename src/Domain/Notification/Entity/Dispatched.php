<?php

declare(strict_types=1);

namespace App\Domain\Notification\Entity;

final class Dispatched
{
    public function __construct(private bool $dispatched)
    {
    }

    public function dispatched(): bool
    {
        return $this->dispatched;
    }
}
