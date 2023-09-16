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
use OpenApi\Annotations as OA;

class ConfirmVerificationAction extends AbstractController
{
    /**
     * Confirms existing verification
     *
     * @OA\Tag(name="verifications")
     * @OA\Parameter(name="verificationId", in="path", required=true, description="Verification ID", @OA\Schema(type="string"), example="123e4567-e89b-12d3-a456-426614174000")
     *
     * @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Property(property="code", type="string", example="1234")
     *     )
     * )
     *
     * @OA\Response(response=204, description="Verification confirmed.")
     * @OA\Response(response=400, description="Malformed JSON passed.")
     * @OA\Response(response=403, description="No permission to confirm verification.")
     * @OA\Response(response=404, description="Verification not found.")
     * @OA\Response(response=410, description="Verification expired.")
     * @OA\Response(response=422, description="Validation failed: invalid code supplied.")
     */
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
