<?php

declare(strict_types=1);

namespace App\Application\Template\Render\Factory;

use App\Application\Template\Render\RenderTemplateCommand;

final class RenderTemplateCommandFactory
{
    public function create(array $data): RenderTemplateCommand
    {
        return new RenderTemplateCommand($data['slug'] ?? '', $data['variables'] ?? []);
    }
}
