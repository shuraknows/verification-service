<?php

declare(strict_types=1);

namespace App\Domain\Verification\Entity;

use App\Domain\Common\Entity\AbstractDomainEventPublishingAggregate;
use App\Domain\Verification\Entity\Subject\Subject;
use App\Domain\Verification\Events\VerificationConfirmationFailed;
use App\Domain\Verification\Events\VerificationConfirmed;
use App\Domain\Verification\Events\VerificationCreated;
use App\Domain\Verification\Exception\Verification\NoPermissionToConfirmVerificationException;
use App\Domain\Verification\Exception\Verification\VerificationCodeMismatchException;
use App\Domain\Verification\Exception\Verification\VerificationDuplicateException;
use App\Domain\Verification\Exception\Verification\VerificationExpiredException;
use App\Domain\Verification\VerificationDuplicateCheckerInterface;
use DateTimeImmutable;

final class Verification extends AbstractDomainEventPublishingAggregate
{
    private const MAX_CONFIRMATION_ATTEMPT_COUNT = 5;

    private VerificationId $id;

    private Subject $subject;

    private Code $code;

    private UserInfo $userInfo;

    private Confirmed $confirmed;

    private ConfirmationAttemptCount $confirmationAttemptCount;

    private CreatedAt $createdAt;

    private ExpiresAt $expiresAt;

    private function __construct(VerificationId $id, Subject $subject, Code $code, UserInfo $userInfo, ExpiresAt $expiresAt)
    {
        $this->id = $id;
        $this->subject = $subject;
        $this->code = $code;
        $this->userInfo = $userInfo;
        $this->expiresAt = $expiresAt;
        $this->confirmationAttemptCount = new ConfirmationAttemptCount();
        $this->confirmed = new Confirmed(false);
        $this->createdAt = new CreatedAt(new DateTimeImmutable());
    }

    public function id(): VerificationId
    {
        return $this->id;
    }

    public function subject(): Subject
    {
        return $this->subject;
    }

    public function code(): Code
    {
        return $this->code;
    }

    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

    public static function create(
        VerificationId $id,
        Subject $subject,
        Code $code,
        UserInfo $userInfo,
        ExpiresAt $expiresAt,
        VerificationDuplicateCheckerInterface $duplicateChecker
    ): self {
        $verification = new self($id, $subject, $code, $userInfo, $expiresAt);

        if ($duplicateChecker->hasDuplicate($verification->subject())) {
            throw new VerificationDuplicateException();
        }

        $verification->record(new VerificationCreated($verification));

        return $verification;
    }

    public function confirm(Code $code, UserInfo $userInfo): void
    {
        if (!$userInfo->equalsTo($this->userInfo)) {
            throw new NoPermissionToConfirmVerificationException();
        }

        if ($this->isVerificationExpired(new DateTimeImmutable())) {
            throw new VerificationExpiredException();
        }

        if ($this->confirmed->isConfirmed()) {
            return;
        }

        if (!$code->equalsTo($this->code)) {
            $this->confirmationAttemptCount->increase();
            $this->record(new VerificationConfirmationFailed($this));

            throw new VerificationCodeMismatchException();
        }

        $this->record(new VerificationConfirmed($this));
        $this->confirmed = new Confirmed(true);
    }

    private function isVerificationExpired(DateTimeImmutable $now): bool
    {
        return $this->expiresAt->isExpired($now) ||
            $this->confirmationAttemptCount->reached(self::MAX_CONFIRMATION_ATTEMPT_COUNT);
    }
}
