<?php

declare(strict_types=1);

namespace App\Domain\Verification\Service;

use App\Domain\Verification\Entity\Subject\Subject;
use App\Domain\Verification\IdentityConfirmedCheckerInterface;
use App\Domain\Verification\VerificationRepositoryInterface;

final readonly class IdentityConfirmedChecker implements IdentityConfirmedCheckerInterface
{
    public function __construct(private readonly VerificationRepositoryInterface $verifications)
    {
    }

    public function identityConfirmed(Subject $subject): bool
    {
        return $this->verifications->getConfirmedBySubject($subject) !== null;
    }
}
