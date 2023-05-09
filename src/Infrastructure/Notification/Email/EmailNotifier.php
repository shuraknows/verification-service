<?php

declare(strict_types=1);

namespace App\Infrastructure\Notification\Email;

use App\Domain\Notification\Entity\Notification;
use App\Domain\Notification\NotifierInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final readonly class EmailNotifier implements NotifierInterface
{
    public function __construct(private string $notificationEmailSubject, private string $notificationSenderEmail, private MailerInterface $mailer)
    {
    }

    public function notify(Notification $notification): void
    {
        $email = (new Email())
            ->from($this->notificationSenderEmail)
            ->to((string) $notification->recipient())
            ->subject($this->notificationEmailSubject)
            ->html((string) $notification->body());

        $this->mailer->send($email);
    }
}
