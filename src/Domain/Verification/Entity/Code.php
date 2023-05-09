<?php

declare(strict_types=1);

namespace App\Domain\Verification\Entity;

use App\Domain\Verification\Exception\Verification\CodeException;

final readonly class Code
{
    private const MAX_CODE_LENGTH = 8;

    public function __construct(private string $code)
    {
        if (strlen($code) >= self::MAX_CODE_LENGTH) {
            throw CodeException::codeIsTooLong(self::MAX_CODE_LENGTH);
        }

        if (strlen($code) === 0) {
            throw CodeException::codeIsEmpty();
        }

        if (!is_numeric($code)) {
            throw CodeException::codeIsNotNumeric($code);
        }
    }

    public function equalsTo(Code $code): bool
    {
        return $this->code === $code->code;
    }

    public function __toString(): string
    {
        return $this->code;
    }
}
