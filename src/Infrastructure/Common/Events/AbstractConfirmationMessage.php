<?php

declare(strict_types=1);

namespace App\Infrastructure\Common\Events;

use App\Domain\Verification\Events\AbstractVerificationEvent;
use DateTimeImmutable;

abstract readonly class AbstractConfirmationMessage
{
    private function __construct(
        private string $verificationId,
        private string $code,
        private string $identity,
        private string $identityType,
        private DateTimeImmutable $occurredAt
    ) {
    }

    public static function fromEvent(AbstractVerificationEvent $event): self
    {
        return new static(
            (string) $event->id(),
            (string) $event->code(),
            (string) $event->subject()->identity(),
            (string) $event->subject()->identityType(),
            $event->occurredAt()
        );
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

    public function identityType(): string
    {
        return $this->identityType;
    }

    public function occurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
