<?php

namespace App\Helpers;

class NumericHelper extends Helper
{
    public static function calcPercentage(int $number, int $total): int
    {
        return (int)(($number * 100) / $total);
    }
}
