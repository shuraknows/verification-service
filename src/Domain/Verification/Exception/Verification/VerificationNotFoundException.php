<?php

declare(strict_types=1);

namespace App\Domain\Verification\Exception\Verification;

use Exception;

final class VerificationNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('Verification not found.');
    }
}
