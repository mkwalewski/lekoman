<?php

namespace App\Helpers;

use Carbon\Carbon;

class NumericHelper extends Helper
{
    public static function calcPercentage(int $number, int $total): int
    {
        return (int)(($number * 100) / $total);
    }
}
