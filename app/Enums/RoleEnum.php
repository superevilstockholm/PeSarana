<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case STUDENT = 'student';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::STUDENT => 'Student',
        };
    }
}
