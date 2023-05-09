<?php

declare(strict_types=1);

namespace App\Domain\Verification\Events;

use App\Domain\Common\DomainEventInterface;
use App\Domain\Verification\Entity\Code;
use App\Domain\Verification\Entity\Subject\Subject;
use App\Domain\Verification\Entity\VerificationId;
use DateTimeImmutable;

abstract readonly class AbstractVerificationEvent implements DomainEventInterface
{
    public function __construct(
        private VerificationId    $id,
        private Code              $code,
        private Subject           $subject,
        private DateTimeImmutable $occurredAt
    ) {
    }

    public function id(): VerificationId
    {
        return $this->id;
    }

    public function code(): Code
    {
        return $this->code;
    }

    public function subject(): Subject
    {
        return $this->subject;
    }

    public function occurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
