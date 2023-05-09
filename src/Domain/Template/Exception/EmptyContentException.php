<?php

declare(strict_types=1);

namespace App\Domain\Template\Exception;

use Exception;

final class EmptyContentException extends Exception
{
    public function __construct()
    {
        parent::__construct('Content cannot be empty');
    }
}
