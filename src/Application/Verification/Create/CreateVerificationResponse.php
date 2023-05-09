<?php

declare(strict_types=1);

namespace App\Application\Verification\Create;

use App\Domain\Verification\Entity\VerificationId;

final readonly class CreateVerificationResponse
{
    public function __construct(private VerificationId $id)
    {
    }

    public function id(): VerificationId
    {
        return $this->id;
    }
}
