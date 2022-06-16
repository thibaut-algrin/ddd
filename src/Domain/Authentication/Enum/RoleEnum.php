<?php

declare(strict_types=1);

namespace App\Domain\Authentication\Enum;

use App\Domain\Shared\Enum\EnumInterface;

class RoleEnum implements EnumInterface
{
    public const SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    public const ADMIN = 'ROLE_ADMIN';
    public const USER = 'ROLE_USER';

    public static function getChoices(): array
    {
        $class = new \ReflectionClass(self::class);

        return array_values($class->getConstants());
    }
}
