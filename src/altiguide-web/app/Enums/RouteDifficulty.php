<?php

namespace App\Enums;

enum RouteDifficulty: string
{
    case EASY = 'easy';
    case MODERATE = 'moderate';
    case HARD = 'hard';

    public function label(): string
    {
        return match($this) {
            self::EASY => 'Pemula (Mudah)',
            self::MODERATE => 'Menengah (Sedang)',
            self::HARD => 'Profesional (Sulit)',
        };
    }
}