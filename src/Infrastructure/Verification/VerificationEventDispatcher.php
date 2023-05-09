<?php

declare(strict_types=1);

namespace App\Infrastructure\Verification;

use App\Domain\Verification\Events\AbstractVerificationEvent;
use App\Domain\Verification\Events\VerificationConfirmationFailed;
use App\Domain\Verification\Events\VerificationConfirmed;
use App\Domain\Verification\Events\VerificationCreated;
use App\Domain\Verification\VerificationEventDispatcherInterface;
use App\Infrastructure\Common\Events\VerificationConfirmationFailedMessage;
use App\Infrastructure\Common\Events\VerificationConfirmedMessage;
use App\Infrastructure\Common\Events\VerificationCreatedMessage;
use InvalidArgumentException;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class VerificationEventDispatcher implements VerificationEventDispatcherInterface
{
    public function __construct(private MessageBusInterface $bus)
    {
    }

    public function dispatch(AbstractVerificationEvent $event): void
    {
        switch (get_class($event)) {
            case VerificationCreated::class:
                $this->bus->dispatch(VerificationCreatedMessage::fromEvent($event));
                break;
            case VerificationConfirmed::class:
                $this->bus->dispatch(VerificationConfirmedMessage::fromEvent($event));
                break;
            case VerificationConfirmationFailed::class:
                $this->bus->dispatch(VerificationConfirmationFailedMessage::fromEvent($event));
                break;
            default:
                throw new InvalidArgumentException('Unknown event class ' . get_class($event));
        }
    }
}
