<?php

declare(strict_types=1);

namespace App\Application\Common\Exception;

use RuntimeException;

final class JsonParsingException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Malformed JSON passed.');
    }
}
