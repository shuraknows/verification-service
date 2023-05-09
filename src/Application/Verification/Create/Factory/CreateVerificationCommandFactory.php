<?php

declare(strict_types=1);

namespace App\Application\Verification\Create\Factory;

use App\Application\Verification\Create\CreateVerificationCommand;

final readonly class CreateVerificationCommandFactory
{
    public function __construct(private int $verificationTTL, private int $validationCodeLength)
    {
    }

    public function create(array $data, ?string $clientIp): CreateVerificationCommand
    {
        return new CreateVerificationCommand(
            $data['subject']['identity'] ?? '',
            $data['subject']['type'] ?? '',
            $clientIp,
            $this->verificationTTL,
            $this->validationCodeLength
        );
    }
}
