<?php

declare(strict_types=1);

namespace App\Domain\Template;

use App\Domain\Template\Entity\Slug;
use App\Domain\Template\Entity\Template;
use App\Domain\Template\Exception\TemplateNotFoundException;

interface TemplateRepositoryInterface
{
    /**
     * @throws TemplateNotFoundException
     */
    public function getBySlug(Slug $slug): ?Template;
}
