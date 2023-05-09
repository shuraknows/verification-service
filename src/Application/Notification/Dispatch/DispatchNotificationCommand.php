<?php

declare(strict_types=1);

namespace App\Application\Notification\Dispatch;

final readonly class DispatchNotificationCommand
{
    public function __construct(private string $notificationId)
    {
    }
    public function notificationId(): string
    {
        return $this->notificationId;
    }
}
