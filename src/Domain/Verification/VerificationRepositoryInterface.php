<?php

declare(strict_types=1);

namespace App\Domain\Verification;

use App\Domain\Verification\Entity\Subject\Subject;
use App\Domain\Verification\Entity\Verification;
use App\Domain\Verification\Entity\VerificationId;
use DateTimeImmutable;

interface VerificationRepositoryInterface
{
    public function get(VerificationId $verificationId): ?Verification;

    public function save(Verification $entity, bool $flush = true): void;

    public function getConfirmedBySubject(Subject $subject): ?Verification;

    public function getPendingVerification(Subject $subject, DateTimeImmutable $now = new DateTimeImmutable()): ?Verification;
}
