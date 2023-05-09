<?php

declare(strict_types=1);

namespace App\Application\Template\Render;

use App\Domain\Template\Entity\RenderingVariables;
use App\Domain\Template\Entity\Slug;
use App\Domain\Template\TemplateRenderingServiceInterface;
use App\Domain\Template\TemplateRepositoryInterface;

final readonly class RenderTemplateCommandHandler
{
    public function __construct(
        private TemplateRepositoryInterface       $templates,
        private TemplateRenderingServiceInterface $renderer
    ) {
    }

    public function __invoke(RenderTemplateCommand $command): RenderTemplateResponse
    {
        $template = $this->templates->getBySlug(new Slug($command->slug()));

        return new RenderTemplateResponse(
            $template->render($this->renderer, new RenderingVariables($command->variables())),
            (string)$template->type()
        );
    }
}
