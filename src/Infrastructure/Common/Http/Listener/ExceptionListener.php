<?php

declare(strict_types=1);

namespace App\Infrastructure\Common\Http\Listener;

use App\Application\Common\Exception\JsonParsingException;
use App\Domain\Template\Exception\InvalidVariablesException;
use App\Domain\Template\Exception\TemplateNotFoundException;
use App\Domain\Verification\Exception\Subject\IdentityAlreadyConfirmedTypeException;
use App\Domain\Verification\Exception\Subject\InvalidIdentityException;
use App\Domain\Verification\Exception\Subject\InvalidIdentityTypeException;
use App\Domain\Verification\Exception\Verification\CodeException;
use App\Domain\Verification\Exception\Verification\NoPermissionToConfirmVerificationException;
use App\Domain\Verification\Exception\Verification\VerificationCodeMismatchException;
use App\Domain\Verification\Exception\Verification\VerificationDuplicateException;
use App\Domain\Verification\Exception\Verification\VerificationExpiredException;
use App\Domain\Verification\Exception\Verification\VerificationNotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class ExceptionListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return ['kernel.exception' => 'onKernelException'];
    }

    public function onKernelException(ExceptionEvent $event, string $eventName = null, EventDispatcherInterface $eventDispatcher = null): void
    {
        match (get_class($event->getThrowable())) {
            // common
            JsonParsingException::class => $event->setResponse(new Response($event->getThrowable()->getMessage(), Response::HTTP_BAD_REQUEST)),

            // template rendering exceptions
            TemplateNotFoundException::class => $event->setResponse(new Response($event->getThrowable()->getMessage(), Response::HTTP_NOT_FOUND)),
            InvalidVariablesException::class => $event->setResponse(new Response($event->getThrowable()->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY)),

            // create verification
            VerificationDuplicateException::class,
            IdentityAlreadyConfirmedTypeException::class => $event->setResponse(new Response($event->getThrowable()->getMessage(), Response::HTTP_CONFLICT)),

            InvalidIdentityException::class,
            InvalidIdentityTypeException::class => $event->setResponse(new Response($event->getThrowable()->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY)),

            // confirm verification
            VerificationExpiredException::class => $event->setResponse(new Response($event->getThrowable()->getMessage(), Response::HTTP_GONE)),
            VerificationCodeMismatchException::class => $event->setResponse(new Response($event->getThrowable()->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY)),
            NoPermissionToConfirmVerificationException::class => $event->setResponse(new Response($event->getThrowable()->getMessage(), Response::HTTP_FORBIDDEN)),
            VerificationNotFoundException::class => $event->setResponse(new Response($event->getThrowable()->getMessage(), Response::HTTP_NOT_FOUND)),
            CodeException::class => $event->setResponse(new Response($event->getThrowable()->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY)),

            default => $event->setResponse(new Response($event->getThrowable()->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR)),
        };
    }
}
