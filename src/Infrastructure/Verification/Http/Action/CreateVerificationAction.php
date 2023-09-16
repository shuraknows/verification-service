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
use OpenApi\Annotations as OA;

class CreateVerificationAction extends AbstractController
{
    /**
     * Create verification for certain channel
     *
     * @OA\Tag(name="verifications")
     * @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *        @OA\Property(
     *           property="subject",
     *           type="object",
     *           required={"type", "identity"},
     *           @OA\Property(property="type", type="string", enum={"email_confirmation", "mobile_confirmation"}),
     *           @OA\Property(property="identity", type="string", example="john.doe@abc.xyz")
     *       ),
     *     )
     * )
     * @OA\Response(
     *     response=201,
     *     description="Verification created.",
     *     @OA\JsonContent(
     *        @OA\Property(property="id", type="string", example="c4d5c6a0-2b1a-4a6a-8f0a-5b9b8b0b9b8b"),
     *     )
     * )
     * @OA\Response(response=400, description="Malformed JSON passed.")
     * @OA\Response(response=409, description="Duplicated verification.")
     * @OA\Response(response=422, description="Validation failed: invalid subject supplied.")
     */
    #[Route('/verifications', name: 'app_verifications_create', methods: ['POST'])]
    public function __invoke(
        Request $request,
        JsonStringDecoder $decoder,
        CreateVerificationCommandFactory $factory,
        CreateVerificationCommandHandler $handler
    ): Response {
        $response = $handler(
            $factory->create(
                $decoder->decode($request->getContent()),
                $request->getClientIp()
            )
        );

        return new JsonResponse(['id' => (string) $response->id()], Response::HTTP_CREATED);
    }
}
