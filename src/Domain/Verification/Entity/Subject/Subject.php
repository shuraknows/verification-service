<?php

declare(strict_types=1);

namespace App\Domain\Verification\Entity\Subject;

use App\Domain\Verification\Exception\Subject\IdentityAlreadyConfirmedTypeException;
use App\Domain\Verification\IdentityConfirmedCheckerInterface;

final readonly class Subject
{
    private function __construct(private Identity $identity, private IdentityType $identityType)
    {
    }

    public static function create(Identity $identity, IdentityType $identityType, IdentityConfirmedCheckerInterface $checker): self
    {
        $subject = new self($identity, $identityType);

        if ($checker->identityConfirmed($subject)) {
            throw new IdentityAlreadyConfirmedTypeException();
        }

        return $subject;
    }

    public function identity(): Identity
    {
        return $this->identity;
    }

    public function identityType(): IdentityType
    {
        return $this->identityType;
    }
}
