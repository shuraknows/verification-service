<?php

declare(strict_types=1);

namespace App\Infrastructure\Notification\SMS;

use App\Domain\Notification\Entity\Notification;
use App\Domain\Notification\NotifierInterface;

final readonly class SMSNotifier implements NotifierInterface
{
    public function __construct(private GotifyClient $client)
    {
    }

    public function notify(Notification $notification): void
    {
        $this->client->message((string) $notification->recipient(), (string) $notification->body());
    }
}
