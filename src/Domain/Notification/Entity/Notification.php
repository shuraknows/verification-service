<?php

declare(strict_types=1);

namespace App\Domain\Notification\Entity;

use App\Domain\Common\Entity\AbstractDomainEventPublishingAggregate;
use App\Domain\Notification\Events\NotificationCreated;
use App\Domain\Notification\Events\NotificationDispatched;
use App\Domain\Notification\NotifierResolverInterface;

final class Notification extends AbstractDomainEventPublishingAggregate
{
    private Dispatched $dispatched;

    private function __construct(
        private readonly NotificationId $id,
        private readonly Recipient $recipient,
        private readonly Channel $channel,
        private readonly Body $body
    ) {
        $this->dispatched = new Dispatched(false);
    }

    public static function create(NotificationId $id, Recipient $recipient, Channel $channel, Body $body): self
    {
        $notification = new self($id, $recipient, $channel, $body);
        $notification->record(new NotificationCreated($id));

        return $notification;
    }

    public function recipient(): Recipient
    {
        return $this->recipient;
    }

    public function channel(): Channel
    {
        return $this->channel;
    }

    public function body(): Body
    {
        return $this->body;
    }

    public function dispatch(NotifierResolverInterface $resolver): void
    {
        $resolver->resolve($this->channel)->notify($this);
        $this->dispatched = new Dispatched(true);
        $this->record(new NotificationDispatched($this->id));
    }
}
