<?php

declare(strict_types=1);

namespace App\Domain\Verification;

interface CodeGeneratorInterface
{
    public function generate(int $length): string;
}
