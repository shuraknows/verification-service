<?php

declare(strict_types=1);

namespace App\Domain\Verification;

use App\Domain\Verification\Entity\Subject\Subject;

interface VerificationDuplicateCheckerInterface
{
    public function hasDuplicate(Subject $subject): bool;
}
