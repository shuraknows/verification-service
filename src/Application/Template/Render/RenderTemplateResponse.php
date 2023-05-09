<?php

declare(strict_types=1);

namespace App\Application\Template\Render;

final readonly class RenderTemplateResponse
{
    public function __construct(private string $content, private string $type)
    {
    }

    public function content(): string
    {
        return $this->content;
    }

    public function type(): string
    {
        return $this->type;
    }
}
