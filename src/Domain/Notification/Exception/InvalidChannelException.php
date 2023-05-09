<?php

declare(strict_types=1);

namespace App\Domain\Notification\Exception;

use Exception;

final class InvalidChannelException extends Exception
{
    public function __construct(string $channel)
    {
        parent::__construct(sprintf('Channel "%s" is invalid', $channel));
    }
}
