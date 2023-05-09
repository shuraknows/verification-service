<?php

declare(strict_types=1);

namespace App\Domain\Template\Exception;

use Exception;

final class InvalidSlugException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid slug');
    }
}
