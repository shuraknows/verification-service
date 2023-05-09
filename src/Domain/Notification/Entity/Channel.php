<?php

declare(strict_types=1);

namespace App\Domain\Notification\Entity;

use App\Domain\Notification\Exception\InvalidChannelException;

final readonly class Channel
{
    private const CHANNEL_EMAIL = 'email';
    private const CHANNEL_SMS = 'sms';

    public function __construct(private string $channel)
    {
        if (!in_array($this->channel, [self::CHANNEL_EMAIL, self::CHANNEL_SMS])) {
            throw new InvalidChannelException($this->channel);
        }
    }

    public function isEmail(): bool
    {
        return $this->channel === self::CHANNEL_EMAIL;
    }

    public function isSms(): bool
    {
        return $this->channel === self::CHANNEL_SMS;
    }

    public function __toString(): string
    {
        return $this->channel;
    }
}
