<?php

declare(strict_types=1);

namespace App\Domain\Verification\Exception\Verification;

use Exception;

final class CodeException extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function codeIsTooLong(int $maxCodeLength): self
    {
        return new CodeException(
            sprintf('Code length exceeds the maximum allowed length of %d characters', $maxCodeLength)
        );
    }

    public static function codeIsEmpty(): self
    {
        return new CodeException('Code is empty');
    }

    public static function codeIsNotNumeric(string $code): self
    {
        return new CodeException(sprintf('Code %s is not numeric', $code));
    }
}
