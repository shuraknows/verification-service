<?php

declare(strict_types=1);

namespace App\Infrastructure\Notification\SMS;

use Gotify\Auth\Token;
use Gotify\Endpoint\Message;
use Gotify\Server;

final readonly class GotifyClient
{
    public function __construct(private string $gotifyServerUrl, private string $gotifyAppToken)
    {
    }

    public function initMessage(): Message
    {
        $server = new Server($this->gotifyServerUrl);
        $auth = new Token($this->gotifyAppToken);

        return new Message($server, $auth);
    }

    public function message(string $title, string $message, int $priority = Message::PRIORITY_HIGH): void
    {
        $this->initMessage()->create($title, $message, $priority);
    }
}
