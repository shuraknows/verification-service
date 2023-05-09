<?php

declare(strict_types=1);

namespace App\Domain\Notification\Entity;

use App\Domain\Common\Entity\AbstractDomainEventPublishingAggregate;
use App\Domain\Notification\Events\NotificationCreated;
use App\Domain\Notification\Events\NotificationDispatched;
use App\Domain\Notification\NotifierResolverInterface;

final class Notification extends AbstractDomainEventPublishingAggregate
{
    private NotificationId $id;
    private Recipient $recipient;
    private Channel $channel;
    private Body $body;
    private Dispatched $dispatched;

    private function __construct(NotificationId $id, Recipient $recipient, Channel $channel, Body $body)
    {
        $this->id = $id;
        $this->recipient = $recipient;
        $this->channel = $channel;
        $this->body = $body;
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
        $this->dispatched->markAsDispatched();
        $this->record(new NotificationDispatched($this->id));
    }
}
