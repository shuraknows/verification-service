<?php

declare(strict_types=1);

namespace App\Domain\Template\Exception;

use App\Domain\Template\Entity\Slug;
use Exception;

final class TemplateNotFoundException extends Exception
{
    public function __construct(Slug $slug)
    {
        parent::__construct(sprintf('Template with slug "%s" not found.', $slug));
    }
}
