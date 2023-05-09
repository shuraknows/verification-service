<?php

declare(strict_types=1);

namespace App\Domain\Notification;

use App\Domain\Notification\Entity\Channel;

interface NotifierResolverInterface
{
    public function resolve(Channel $channel): NotifierInterface;
}
