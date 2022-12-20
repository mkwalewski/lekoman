<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper extends Helper
{
    public static function isSameDay(string $date, string $dateHistory): bool
    {
        $dateTaken = Carbon::parse($date)->startOfDay();
        $dateTakenHistory = Carbon::parse($dateHistory)->startOfDay();

        if ($dateTakenHistory->diffInDays($dateTaken) === 0) {
            return true;
        }

        return false;
    }

    public static function getCurrentYear(): int
    {
        return (int)date('Y');
    }

    public static function getCurrentWeek(): int
    {
        $date = new \DateTime();

        return (int)$date->format('W');
    }

    public static function getNumberOfWeeksByYear(int $year): int
    {
        $date = new \DateTime($year . '-12-28');

        return (int)$date->format('W');
    }

    public static function getWeeksByNumber(int $weeks, int $year): array
    {
        $weeksData = [];

        foreach (range(1, $weeks) as $week) {
            $value = __('Tydzień');
            $value .= ' ' . $week . ' (';
            $date = new \DateTime();
            $date->setISODate($year, $week);
            $value .= $date->format('d-m-Y');
            $date->modify('+6 days');
            $value .= ' - ' .$date->format('d-m-Y') . ')';
            $weeksData[$week] = $value;
        }

        return $weeksData;
    }

    public static function getWeekData(int $week, int $year): array
    {
        $weekData = [];
        $date = new \DateTime();
        $date->setISODate($year, $week);

        for ($i = 0; $i <= 6; $i++) {
            $weekData[] = $date->format('Y-m-d');
            $date->modify('+1 days');
        }

        return $weekData;
    }
}
