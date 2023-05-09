<?php

declare(strict_types=1);

namespace App\Domain\Template\Entity;

final class RenderingVariables
{
    public function __construct(private array $variables)
    {
    }

    public function toArray(): array
    {
        return $this->variables;
    }
}
