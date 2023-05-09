<?php

declare(strict_types=1);

namespace App\Application\Common\Decoder;

use App\Application\Common\Exception\JsonParsingException;
use JsonException;

final class JsonStringDecoder
{
    public function decode(string $string): array
    {
        try {
            return json_decode(json: $string, associative: true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new JsonParsingException();
        }
    }
}
