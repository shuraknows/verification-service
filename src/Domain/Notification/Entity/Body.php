<?php

declare(strict_types=1);

namespace App\Domain\Notification\Entity;

use App\Domain\Notification\Exception\InvalidBodyException;

final readonly class Body
{
    public function __construct(private string $body)
    {
        if (empty($body)) {
            throw new InvalidBodyException();
        }
    }

    public function __toString(): string
    {
        return $this->body;
    }
}
