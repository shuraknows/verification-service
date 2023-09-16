<?php

declare(strict_types=1);

namespace App\Application\Notification\Create\Service;

use App\Domain\Notification\Entity\Channel;
use App\Infrastructure\Template\Http\Client\TemplateServiceClient;
use InvalidArgumentException;

final readonly class VerificationBodyRenderingService
{
    public function __construct(private TemplateServiceClient $client)
    {
    }

    public function render(Channel $channel, string $code): string
    {
        return $this->client->requestVerificationBody($code, $this->resolveSlug($channel));
    }

    private function resolveSlug(Channel $channel): string
    {
        return match (true) {
            $channel->isEmail() => 'email-verification',
            $channel->isSms() => 'mobile-verification',
            default => throw new InvalidArgumentException('Invalid channel'),
        };
    }
}
