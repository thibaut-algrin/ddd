<?php

declare(strict_types=1);

namespace App\Domain\Authentication\Enum;

use App\Domain\Shared\Enum\EnumInterface;

class LanguageEnum implements EnumInterface
{
    public const FR = 'fr';
    public const EN = 'en';
    public const ES = 'es';
    public const DE = 'de';
    public const IT = 'it';

    public static function getChoices(): array
    {
        $class = new \ReflectionClass(self::class);

        return array_values($class->getConstants());
    }
}
