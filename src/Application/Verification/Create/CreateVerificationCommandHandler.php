<?php

declare(strict_types=1);

namespace App\Application\Verification\Create;

use App\Domain\Verification\CodeGeneratorInterface;
use App\Domain\Verification\Entity\Code;
use App\Domain\Verification\Entity\ExpiresAt;
use App\Domain\Verification\Entity\Subject\Identity;
use App\Domain\Verification\Entity\Subject\IdentityType;
use App\Domain\Verification\Entity\Subject\Subject;
use App\Domain\Verification\Entity\UserInfo;
use App\Domain\Verification\Entity\Verification;
use App\Domain\Verification\Entity\VerificationId;
use App\Domain\Verification\IdentityConfirmedCheckerInterface;
use App\Domain\Verification\VerificationDuplicateCheckerInterface;
use App\Domain\Verification\VerificationEventDispatcherInterface;
use App\Domain\Verification\VerificationRepositoryInterface;
use DateTimeImmutable;

final readonly class CreateVerificationCommandHandler
{
    public function __construct(
        private CodeGeneratorInterface                $codeGenerator,
        private VerificationRepositoryInterface       $verifications,
        private IdentityConfirmedCheckerInterface     $confirmedChecker,
        private VerificationDuplicateCheckerInterface $duplicateChecker,
        private VerificationEventDispatcherInterface  $dispatcher,
    ) {
    }

    public function __invoke(CreateVerificationCommand $command): CreateVerificationResponse
    {

        $verification = Verification::create(
            VerificationId::next(),
            Subject::create(
                new Identity($command->identity()),
                new IdentityType($command->type()),
                $this->confirmedChecker
            ),
            new Code($this->codeGenerator->generate($command->codeLength())),
            new UserInfo($command->clientIp()),
            new ExpiresAt(new DateTimeImmutable(sprintf('now + %d seconds', $command->ttl()))),
            $this->duplicateChecker
        );

        $this->verifications->save($verification);

        foreach ($verification->publishEvents() as $event) {
            $this->dispatcher->dispatch($event);
        }

        return new CreateVerificationResponse($verification->id());
    }
}
