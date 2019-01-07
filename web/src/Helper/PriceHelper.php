<?php

declare(strict_types=1);

namespace App\Helper;

final class PriceHelper
{
    public function convertToHumanPrice(int $price): float
    {
        return (float) \round($price / 100, 2);
    }

    public function convertToIntegerPrice(float $price): int
    {
        return (int) \round($price * 100, 2);
    }
}