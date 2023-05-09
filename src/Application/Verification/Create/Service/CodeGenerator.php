<?php

declare(strict_types=1);

namespace App\Application\Verification\Create\Service;

use App\Domain\Verification\CodeGeneratorInterface;

final class CodeGenerator implements CodeGeneratorInterface
{
    public function generate(int $length): string
    {
        $code = '';

        for ($i = 0; $i < $length; $i++) {
            $code .= random_int(0, 9);
        }

        return $code;
    }
}
