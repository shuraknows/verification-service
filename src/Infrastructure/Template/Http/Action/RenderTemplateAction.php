<?php

declare(strict_types=1);

namespace App\Infrastructure\Template\Http\Action;

use App\Application\Common\Decoder\JsonStringDecoder;
use App\Application\Template\Render\Factory\RenderTemplateCommandFactory;
use App\Application\Template\Render\RenderTemplateCommandHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class RenderTemplateAction extends AbstractController
{
    /**
     * Renders template of certain type passed in slug with variables
     *
     * @OA\Tag(name="templates")
     * @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Property(property="slug", type="string", enum={"mobile-verification", "email-verification"}),
     *          @OA\Property(property="variables", type="object", example={"code": "1234"})
     *     )
     * )
     *
     * @OA\Response(response=200, description="Template rendered.")
     * @OA\Response(response=400, description="Malformed JSON passed.")
     * @OA\Response(response=404, description="Template not found.")
     * @OA\Response(response=422, description="Validation failed: invalid / missing variables supplied.")
     */
    #[Route('/templates/render', name: 'app_template_render', methods: ['POST'])]
    public function __invoke(
        Request $request,
        RenderTemplateCommandHandler $handler,
        JsonStringDecoder $decoder,
        RenderTemplateCommandFactory $factory
    ): Response {
        $response = $handler(
            $factory->create(
                $decoder->decode($request->getContent())
            )
        );

        return new Response(
            $response->content(),
            Response::HTTP_OK,
            [
                'Content-Type' => sprintf('text/%s; charset=UTF-8', $response->type()),
                'Content-Length' => strlen($response->content())
            ]
        );
    }
}
