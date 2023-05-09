<?php

declare(strict_types=1);

namespace App\Application\Verification\Confirm;

use Symfony\Component\Uid\Uuid;

final readonly class ConfirmVerificationCommand
{
    public function __construct(private Uuid $verificationId, private string $code, private ?string $ip)
    {
    }

    public function verificationId(): Uuid
    {
        return $this->verificationId;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function ip(): string
    {
        return $this->ip;
    }
}
