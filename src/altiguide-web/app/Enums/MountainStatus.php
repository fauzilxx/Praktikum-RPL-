<?php

namespace App\Enums;

enum MountainStatus: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
    case ALERT = 'alert';

    public function label(): string
    {
        return match($this) {
            self::OPEN => 'Buka',
            self::CLOSED => 'Tutup (Pemulihan/Renovasi)',
            self::ALERT => 'Waspada (Cuaca/Aktivitas Vulkanik)',
        };
    }
}