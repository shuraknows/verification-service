<?php

declare(strict_types=1);

namespace App\Domain\Verification\Entity\Subject;

use App\Domain\Verification\Exception\Subject\InvalidIdentityTypeException;

final readonly class IdentityType
{
    private const EMAIL_CONFIRMATION = 'email_confirmation';
    private const MOBILE_CONFIRMATION = 'mobile_confirmation';

    public function __construct(private string $identityType)
    {
        if (!in_array($identityType, [self::EMAIL_CONFIRMATION, self::MOBILE_CONFIRMATION])) {
            throw new InvalidIdentityTypeException();
        }
    }

    public function __toString(): string
    {
        return $this->identityType;
    }
}
