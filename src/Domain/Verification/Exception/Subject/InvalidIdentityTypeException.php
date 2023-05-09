<?php

declare(strict_types=1);

namespace App\Domain\Verification\Exception\Subject;

use Exception;

final class InvalidIdentityTypeException extends Exception
{
    public function __construct()
    {
        parent::__construct('Validation failed: invalid subject supplied.');
    }
}
