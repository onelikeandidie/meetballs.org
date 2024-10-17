<?php

namespace App\Libraries\Helper\Color;

use Nette\Utils\Random;

class Color
{
    // Pastel colour list from tailwind
    // https://tailwindcss.com/docs/customizing-colors
    const PASTEL_COLORS = [
        '#ef4444',
        '#f97316',
        '#f59e0b',
        '#eab308',
        '#84cc16',
        '#22c55e',
        '#10b981',
        '#14b8a6',
        '#06b6d4',
        '#0ea5e9',
        '#3b82f6',
        '#6366f1',
        '#8b5cf6',
        '#d946ef',
        '#ec4899',
        '#f43f5e',
    ];

    protected static $takenColors = [];

    public static function Random()
    {
        $index = round(rand(0, count(self::PASTEL_COLORS) - 1));
        if (isset(self::$takenColors[$index])) {
            if (count(self::$takenColors) === count(self::PASTEL_COLORS)) {
                // Reset taken colors
                self::$takenColors = [];
            }
            return self::Random();
        }
        self::$takenColors[$index] = true;
        return self::PASTEL_COLORS[$index];
    }
}
