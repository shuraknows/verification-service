<?php

declare(strict_types=1);

namespace App\Application\Notification\Create;

use DateTimeImmutable;

final readonly class CreateNotificationCommand
{
    public function __construct(
        private string            $verificationId,
        private string            $code,
        private string            $identity,
        private string            $channel,
        private DateTimeImmutable $occurredAt
    ) {
    }

    public function verificationId(): string
    {
        return $this->verificationId;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function identity(): string
    {
        return $this->identity;
    }

    public function channel(): string
    {
        return $this->channel;
    }

    public function occurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
