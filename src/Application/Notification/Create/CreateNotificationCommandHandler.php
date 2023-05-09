<?php

declare(strict_types=1);

namespace App\Application\Notification\Create;

use App\Application\Notification\Create\Service\VerificationBodyRenderingService;
use App\Domain\Notification\Entity\Body;
use App\Domain\Notification\Entity\Channel;
use App\Domain\Notification\Entity\Notification;
use App\Domain\Notification\Entity\NotificationId;
use App\Domain\Notification\Entity\Recipient;
use App\Domain\Notification\NotificationEventDispatcherInterface;
use App\Domain\Notification\NotificationRepositoryInterface;

final readonly class CreateNotificationCommandHandler
{
    public function __construct(
        private NotificationRepositoryInterface $notifications,
        private VerificationBodyRenderingService $renderingService,
        private NotificationEventDispatcherInterface $dispatcher
    ) {
    }

    public function __invoke(CreateNotificationCommand $command): void
    {
        $channel = new Channel($command->channel());

        $notification = Notification::create(
            NotificationId::next(),
            new Recipient($command->identity()),
            $channel,
            new Body(
                $this->renderingService->render($channel, $command->code())
            )
        );

        foreach ($notification->publishEvents() as $event) {
            $this->dispatcher->dispatch($event);
        }

        $this->notifications->save($notification);
    }
}
