<?php

declare(strict_types=1);

namespace App\Domain\Verification\Events;

use App\Domain\Verification\Entity\Verification;
use DateTimeImmutable;

final readonly class VerificationConfirmed extends AbstractVerificationEvent
{
    public function __construct(Verification $verification)
    {
        parent::__construct($verification->id(), $verification->code(), $verification->subject(), new DateTimeImmutable());
    }
}
