<?php

namespace App\Helpers;

use App\Models\MedicinesDoses;

class HttpHelper extends Helper
{
    public static function getClassForPercentage(string $schedule, int $number): string
    {
        if ($schedule === MedicinesDoses::SCHEDULE_OCCASIONALLY) {
            return 'secondary';
        }

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

    public static function getClassForActive(int $index, array $options): string
    {
        if ($index === 0) {
            return $options[0];
        }

        return $options[1];
    }

    public static function getIconForSchedule(string $schedule): string
    {
        if ($schedule === MedicinesDoses::SCHEDULE_EVERYDAY) {
            return 'exclamation';
        }

        if ($schedule === MedicinesDoses::SCHEDULE_OCCASIONALLY) {
            return 'help';
        }

        return '';
    }
}
