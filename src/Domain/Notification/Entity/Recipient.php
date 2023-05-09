<?php

declare(strict_types=1);

namespace App\Domain\Notification\Entity;

use App\Domain\Notification\Exception\InvalidRecipientException;

final readonly class Recipient
{
    public function __construct(private string $recipient)
    {
        if (empty($recipient)) {
            throw new InvalidRecipientException();
        }
    }

    public function __toString(): string
    {
        return $this->recipient;
    }
}
