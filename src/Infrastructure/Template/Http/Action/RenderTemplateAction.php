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

class RenderTemplateAction extends AbstractController
{
    #[Route('/templates/render', name: 'app_template_render', methods: ['POST'])]
    public function __invoke(
        Request                      $request,
        RenderTemplateCommandHandler $handler,
        JsonStringDecoder            $decoder,
        RenderTemplateCommandFactory $factory
    ): Response {
        $response = $handler(
            $factory->create(
                $decoder->decode(
                    $request->getContent()
                )
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
