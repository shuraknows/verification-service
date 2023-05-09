<?php

namespace App\Application\Notification\Dispatch\Service;

use App\Domain\Notification\Entity\Channel;
use App\Domain\Notification\Exception\UnsupportedNotificationChannelException;
use App\Domain\Notification\NotifierInterface;
use App\Domain\Notification\NotifierResolverInterface;
use App\Infrastructure\Notification\Email\EmailNotifier;
use App\Infrastructure\Notification\SMS\SMSNotifier;

final class NotifierResolver implements NotifierResolverInterface
{
    public function __construct(private EmailNotifier $emailNotifier, private SMSNotifier $smsNotifier)
    {
    }

    public function resolve(Channel $channel): NotifierInterface
    {
        switch (true) {
            case $channel->isEmail():
                return $this->emailNotifier;
            case $channel->isSms():
                return $this->smsNotifier;
            default:
                throw new UnsupportedNotificationChannelException((string) $channel);
        }
    }
}
