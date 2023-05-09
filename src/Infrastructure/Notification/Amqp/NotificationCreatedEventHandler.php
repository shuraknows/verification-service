<?php

declare(strict_types=1);

namespace App\Infrastructure\Notification\Amqp;

use App\Application\Notification\Dispatch\DispatchNotificationCommand;
use App\Application\Notification\Dispatch\DispatchNotificationCommandHandler;
use App\Infrastructure\Common\Events\NotificationCreatedMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class NotificationCreatedEventHandler
{
    public function __construct(private DispatchNotificationCommandHandler $handler)
    {

    }

    public function __invoke(NotificationCreatedMessage $message): void
    {
        ($this->handler)(new DispatchNotificationCommand($message->notificationId()));
    }
}
