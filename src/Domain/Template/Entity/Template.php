<?php

declare(strict_types=1);

namespace App\Domain\Template\Entity;

use App\Domain\Template\Exception\InvalidVariablesException;
use App\Domain\Template\TemplateRenderingServiceInterface;

final readonly class Template
{
    private TemplateId $id;
    private Slug $slug;
    private Content $content;
    private Type $type;

    public function content(): Content
    {
        return $this->content;
    }

    public function type(): Type
    {
        return $this->type;
    }

    /**
     * @throws InvalidVariablesException
     */
    public function render(TemplateRenderingServiceInterface $renderer, RenderingVariables $variables): string
    {
        return $renderer->render($this, $variables);
    }
}
