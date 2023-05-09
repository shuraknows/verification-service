<?php

declare(strict_types=1);

namespace App\Infrastructure\Verification\Http\Action;

use App\Application\Common\Decoder\JsonStringDecoder;
use App\Application\Verification\Create\CreateVerificationCommandHandler;
use App\Application\Verification\Create\Factory\CreateVerificationCommandFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateVerificationAction extends AbstractController
{
    #[Route('/verifications', name: 'app_verifications_create', methods: ['POST'])]
    public function __invoke(
        Request                          $request,
        JsonStringDecoder                $decoder,
        CreateVerificationCommandFactory $factory,
        CreateVerificationCommandHandler $handler
    ): Response {
        $response = $handler(
            $factory->create(
                $decoder->decode($request->getContent()),
                $request->getClientIp()
            )
        );

        return new JsonResponse(['id' => (string)$response->id()], Response::HTTP_CREATED);
    }
}
