<?php

namespace App\Helpers;

use Carbon\Carbon;

class HttpHelper extends Helper
{
    public static function getClassForPercentage(int $number): string
    {
        if ($number >= 75) {
            return 'danger';
        }

        if ($number >= 50) {
            return 'warning';
        }

        if ($number > 0) {
            return 'success';
        }

        return 'primary';
    }
}
