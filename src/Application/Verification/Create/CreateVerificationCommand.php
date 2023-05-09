<?php

declare(strict_types=1);

namespace App\Application\Verification\Create;

final readonly class CreateVerificationCommand
{
    public function __construct(
        private string  $identity,
        private string  $type,
        private ?string $clientIp,
        private int     $ttl,
        private int     $codeLength,
    ) {
    }

    public function identity(): string
    {
        return $this->identity;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function clientIp(): ?string
    {
        return $this->clientIp;
    }

    public function ttl(): int
    {
        return $this->ttl;
    }

    public function codeLength(): int
    {
        return $this->codeLength;
    }
}
