<?php

declare(strict_types=1);

namespace App\Domain\Shared\Enum;

interface EnumInterface
{
    public static function getChoices(): array;
}
