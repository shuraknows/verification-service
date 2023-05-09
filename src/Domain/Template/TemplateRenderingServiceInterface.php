<?php

declare(strict_types=1);

namespace App\Domain\Template;

use App\Domain\Template\Entity\RenderingVariables;
use App\Domain\Template\Entity\Template;
use App\Domain\Template\Exception\InvalidVariablesException;

interface TemplateRenderingServiceInterface
{
    /**
     * @throws InvalidVariablesException
     */
    public function render(Template $template, RenderingVariables $variables): string;
}
