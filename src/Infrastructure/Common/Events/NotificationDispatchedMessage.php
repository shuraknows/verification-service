<?php

declare(strict_types=1);

namespace App\Infrastructure\Common\Events;

final readonly class NotificationDispatchedMessage
{
    public function __construct(private string $notificationId)
    {

    }

    public function notificationId(): string
    {
        return $this->notificationId;
    }
}
