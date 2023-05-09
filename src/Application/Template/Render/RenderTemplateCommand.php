<?php

declare(strict_types=1);

namespace App\Application\Template\Render;

final readonly class RenderTemplateCommand
{
    public function __construct(private string $slug, private array $variables)
    {
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function variables(): array
    {
        return $this->variables;
    }
}
