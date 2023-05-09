<?php

declare(strict_types=1);

namespace App\Domain\Verification;

use App\Domain\Verification\Events\AbstractVerificationEvent;

interface VerificationEventDispatcherInterface
{
    public function dispatch(AbstractVerificationEvent $subject): void;
}
