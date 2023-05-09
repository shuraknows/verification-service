<?php

declare(strict_types=1);

namespace App\Domain\Notification;

use App\Domain\Notification\Entity\Notification;

interface NotifierInterface
{
    public function notify(Notification $notification): void;
}
