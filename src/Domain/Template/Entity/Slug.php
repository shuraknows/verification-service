<?php

declare(strict_types=1);

namespace App\Domain\Template\Entity;

use App\Domain\Template\Exception\InvalidSlugException;

final readonly class Slug
{
    public function __construct(private string $slug)
    {
        if (empty($slug)) {
            throw new InvalidSlugException();
        }
    }

    public function __toString(): string
    {
        return $this->slug;
    }
}
