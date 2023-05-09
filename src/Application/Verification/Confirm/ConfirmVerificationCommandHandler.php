<?php

declare(strict_types=1);

namespace App\Application\Verification\Confirm;

use App\Domain\Verification\Entity\Code;
use App\Domain\Verification\Entity\UserInfo;
use App\Domain\Verification\Entity\VerificationId;
use App\Domain\Verification\VerificationEventDispatcherInterface;
use App\Domain\Verification\VerificationRepositoryInterface;

final readonly class ConfirmVerificationCommandHandler
{
    public function __construct(
        private VerificationRepositoryInterface      $verificationRepository,
        private VerificationEventDispatcherInterface $dispatcher,
    ) {
    }

    public function __invoke(ConfirmVerificationCommand $command): void
    {
        $verification = $this->verificationRepository->get(
            new VerificationId($command->verificationId())
        );

        try {
            $verification->confirm(
                new Code($command->code()),
                new UserInfo($command->ip())
            );
        } finally {
            foreach ($verification->publishEvents() as $event) {
                $this->dispatcher->dispatch($event);
            }

            $this->verificationRepository->save($verification);
        }
    }
}
