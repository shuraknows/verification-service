<?php

declare(strict_types=1);

namespace App\Domain\Common\Entity;

use Symfony\Component\Uid\Uuid;

abstract class AbstractId
{
    public function __construct(protected Uuid $id)
    {

    }

    public static function fromString(string $uuid): static
    {
        return new static(Uuid::fromString($uuid));
    }

    public function __toString(): string
    {
        return $this->id->toRfc4122();
    }

    public static function next(): static
    {
        return new static(Uuid::v4());
    }
}
