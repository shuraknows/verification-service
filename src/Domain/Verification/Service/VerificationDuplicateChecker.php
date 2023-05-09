<?php

declare(strict_types=1);

namespace App\Domain\Verification\Service;

use App\Domain\Verification\Entity\Subject\Subject;
use App\Domain\Verification\VerificationDuplicateCheckerInterface;
use App\Domain\Verification\VerificationRepositoryInterface;

final readonly class VerificationDuplicateChecker implements VerificationDuplicateCheckerInterface
{
    public function __construct(private VerificationRepositoryInterface $verifications)
    {
    }

    public function hasDuplicate(Subject $subject): bool
    {
        return null !== $this->verifications->getPendingVerification($subject);
    }
}
