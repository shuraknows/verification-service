<?php

declare(strict_types=1);

namespace App\Application\Notification\Dispatch;

use App\Domain\Notification\Entity\NotificationId;
use App\Domain\Notification\NotificationEventDispatcherInterface;
use App\Domain\Notification\NotificationRepositoryInterface;
use App\Domain\Notification\NotifierResolverInterface;

final readonly class DispatchNotificationCommandHandler
{
    public function __construct(
        private NotificationRepositoryInterface $notifications,
        private NotifierResolverInterface $notifierResolver,
        private NotificationEventDispatcherInterface $dispatcher
    ) {
    }

    public function __invoke(DispatchNotificationCommand $command): void
    {
        $notification = $this->notifications->get(
            NotificationId::fromString($command->notificationId())
        );

        $notification->dispatch($this->notifierResolver);
        $this->notifications->save($notification);

        foreach ($notification->publishEvents() as $event) {
            $this->dispatcher->dispatch($event);
        }
    }
}
