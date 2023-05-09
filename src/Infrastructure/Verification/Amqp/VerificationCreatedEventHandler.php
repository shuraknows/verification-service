<?php

declare(strict_types=1);

namespace App\Infrastructure\Verification\Amqp;

use App\Application\Notification\Create\CreateNotificationCommand;
use App\Application\Notification\Create\CreateNotificationCommandHandler;
use App\Infrastructure\Common\Events\VerificationCreatedMessage;
use InvalidArgumentException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class VerificationCreatedEventHandler
{
    public function __construct(private CreateNotificationCommandHandler $handler)
    {

    }

    public function __invoke(VerificationCreatedMessage $message): void
    {
        ($this->handler)(
            new CreateNotificationCommand(
                $message->verificationId(),
                $message->code(),
                $message->identity(),
                $this->identityTypeToChannel($message->identityType()),
                $message->occurredAt()
            )
        );
    }

    private function identityTypeToChannel(string $identityType): string
    {
        return match ($identityType) {
            'email_confirmation' => 'email',
            'mobile_confirmation' => 'sms',
            default => throw new InvalidArgumentException('Unknown identity type')
        };
    }
}
