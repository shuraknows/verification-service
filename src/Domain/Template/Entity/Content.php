<?php

declare(strict_types=1);

namespace App\Domain\Template\Entity;

use App\Domain\Template\Exception\EmptyContentException;

final class Content
{
    public function __construct(private readonly string $content)
    {
        if (empty($content)) {
            throw new EmptyContentException();
        }
    }

    public function __toString(): string
    {
        return $this->content;
    }
}
