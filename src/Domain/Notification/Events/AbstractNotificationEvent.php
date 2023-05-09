<?php

declare(strict_types=1);

namespace App\Domain\Notification\Events;

use App\Domain\Common\DomainEventInterface;
use App\Domain\Notification\Entity\NotificationId;

readonly class AbstractNotificationEvent implements DomainEventInterface
{
    public function __construct(private NotificationId $notificationId)
    {
    }

    public function notificationId(): NotificationId
    {
        return $this->notificationId;
    }
}
