<?php

declare(strict_types=1);

namespace App\Domain\Notification;

use App\Domain\Notification\Events\AbstractNotificationEvent;

interface NotificationEventDispatcherInterface
{
    public function dispatch(AbstractNotificationEvent $subject): void;
}
