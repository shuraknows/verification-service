<?php

declare(strict_types=1);

namespace App\Application\Verification\Confirm\Factory;

use App\Application\Verification\Confirm\ConfirmVerificationCommand;
use Symfony\Component\Uid\Uuid;

final readonly class ConfirmVerificationCommandFactory
{
    public function create(string $verificationId, array $data, ?string $ip): ConfirmVerificationCommand
    {
        return new ConfirmVerificationCommand(
            verificationId: Uuid::fromString($verificationId),
            code: $data['code'] ?? '',
            ip: $ip
        );
    }
}
