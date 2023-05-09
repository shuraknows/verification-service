<?php

declare(strict_types=1);

namespace App\Domain\Notification\Exception;

use Exception;

final class NotificationNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('Notification not found.');
    }
}
