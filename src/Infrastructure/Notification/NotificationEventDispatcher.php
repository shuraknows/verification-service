<?php

declare(strict_types=1);

namespace App\Infrastructure\Notification;

use App\Domain\Notification\Events\AbstractNotificationEvent;
use App\Domain\Notification\Events\NotificationCreated;
use App\Domain\Notification\Events\NotificationDispatched;
use App\Domain\Notification\NotificationEventDispatcherInterface;
use App\Infrastructure\Common\Events\NotificationCreatedMessage;
use App\Infrastructure\Common\Events\NotificationDispatchedMessage;
use InvalidArgumentException;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class NotificationEventDispatcher implements NotificationEventDispatcherInterface
{
    public function __construct(private MessageBusInterface $bus)
    {
    }

    public function dispatch(AbstractNotificationEvent $event): void
    {
        switch (get_class($event)) {
            case NotificationCreated::class:
                $this->bus->dispatch(new NotificationCreatedMessage((string) $event->notificationId()));
                break;
            case NotificationDispatched::class:
                $this->bus->dispatch(new NotificationDispatchedMessage((string) $event->notificationId()));
                break;
            default:
                throw new InvalidArgumentException('Unknown event class ' . get_class($event));
        }
    }
}
