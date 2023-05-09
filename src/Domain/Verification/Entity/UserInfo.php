<?php

declare(strict_types=1);

namespace App\Domain\Verification\Entity;

use App\Domain\Verification\Exception\Verification\InvalidIpException;

final readonly class UserInfo
{
    public function __construct(private ?string $ip)
    {
        if (null === $ip || filter_var($ip, FILTER_VALIDATE_IP) === false) {
            throw new InvalidIpException();
        }
    }

    public function equalsTo(UserInfo $other): bool
    {
        return $this->ip === $other->ip;
    }
}
