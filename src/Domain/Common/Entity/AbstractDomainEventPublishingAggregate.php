<?php

declare(strict_types=1);

namespace App\Domain\Common\Entity;

use App\Domain\Common\DomainEventInterface;

abstract class AbstractDomainEventPublishingAggregate
{
    /**
     * @var array|DomainEventInterface[]
     */
    private $domainEvents = [];

    protected function record(DomainEventInterface $event): void
    {
        $this->domainEvents[] = $event;
    }

    /**
     * @return array|DomainEventInterface[]
     */
    public function publishEvents(): array
    {
        $events = $this->domainEvents;
        $this->domainEvents = [];

        return $events;
    }
}
