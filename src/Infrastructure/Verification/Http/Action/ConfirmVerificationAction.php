<?php

declare(strict_types=1);

namespace App\Infrastructure\Verification\Http\Action;

use App\Application\Common\Decoder\JsonStringDecoder;
use App\Application\Verification\Confirm\ConfirmVerificationCommandHandler;
use App\Application\Verification\Confirm\Factory\ConfirmVerificationCommandFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfirmVerificationAction extends AbstractController
{
    #[Route('/verifications/{verificationId}/confirm', name: 'app_verifications_confirm', methods: ['PUT'])]
    public function __invoke(
        string $verificationId,
        Request $request,
        JsonStringDecoder $decoder,
        ConfirmVerificationCommandFactory $factory,
        ConfirmVerificationCommandHandler $handler
    ): Response {
        $handler(
            $factory->create(
                $verificationId,
                $decoder->decode($request->getContent()),
                $request->getClientIp()
            )
        );

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
