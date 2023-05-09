<?php

declare(strict_types=1);

namespace App\Application\Template\Render\Service;

use App\Domain\Template\Entity\RenderingVariables;
use App\Domain\Template\Entity\Template;
use App\Domain\Template\Exception\InvalidVariablesException;
use App\Domain\Template\TemplateRenderingServiceInterface;

final class TemplateRendering implements TemplateRenderingServiceInterface
{
    public function render(Template $template, RenderingVariables $variables): string
    {
        $result = (string)$template->content();

        foreach ($variables->toArray() as $key => $value) {
            $result = str_replace('{{ ' . $key . ' }}', $value, $result);
        }

        if (str_contains($result, '{{ ') && str_contains($result, ' }}')) {
            throw new InvalidVariablesException();
        }

        return $result;
    }
}
