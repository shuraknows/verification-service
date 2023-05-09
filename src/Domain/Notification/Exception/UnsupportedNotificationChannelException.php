<?php

declare(strict_types=1);

namespace App\Domain\Notification\Exception;

use Exception;

final class UnsupportedNotificationChannelException extends Exception
{
    public function __construct(string $channel)
    {
        parent::__construct(sprintf('Unsupported notification channel: %s', $channel));
    }
}
