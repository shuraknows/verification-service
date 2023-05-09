<?php

declare(strict_types=1);

namespace App\Domain\Template\Entity;

use DomainException;

final readonly class Type
{
    private const TYPE_HTML = 'html';
    private const TYPE_PLAIN = 'plain';

    public function __construct(private string $type)
    {
        if (!in_array($type, [self::TYPE_HTML, self::TYPE_PLAIN])) {
            throw new DomainException('Invalid slug');
        }
    }

    public function __toString(): string
    {
        return $this->type;
    }
}
