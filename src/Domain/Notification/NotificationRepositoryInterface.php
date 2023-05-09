<?php

declare(strict_types=1);

namespace App\Domain\Notification;

use App\Domain\Notification\Entity\Notification;
use App\Domain\Notification\Entity\NotificationId;

interface NotificationRepositoryInterface
{
    public function get(NotificationId $notificationId): Notification;

    public function save(Notification $entity, bool $flush = true): void;
}
