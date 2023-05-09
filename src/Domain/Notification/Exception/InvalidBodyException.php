<?php

declare(strict_types=1);

namespace App\Domain\Notification\Exception;

use Exception;

final class InvalidBodyException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid body');
    }
}
