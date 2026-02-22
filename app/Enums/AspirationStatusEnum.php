<?php

namespace App\Enums;

enum AspirationStatusEnum: string
{
    case PENDING = 'pending';
    case ON_GOING = 'on_going';
    case COMPLETED = 'completed';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Menunggu',
            self::ON_GOING => 'Proses',
            self::COMPLETED => 'Selesai',
            self::REJECTED => 'Ditolak',
        };
    }
}
