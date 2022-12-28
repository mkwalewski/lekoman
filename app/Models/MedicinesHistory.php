<?php

namespace App\Models;

use App\Exceptions\MedicinesHistoryNotFoundException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MedicinesHistory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $dates = ['time_taken'];

    public function medicines()
    {
        return $this->belongsTo(Medicines::class);
    }

    public static function tryAdd(array $input): int
    {
        try {
            $medicinesHistory = new MedicinesHistory();
            $medicinesHistory->medicines_id = $input['medicines_id'];
            $medicinesHistory->amount = $input['amount'];
            $medicinesHistory->time_taken = Carbon::now();
            $medicinesHistory->save();
        } catch (\Exception $exception) {
            report($exception);

            return 0;
        }

        return $medicinesHistory->id;
    }

    public static function tryDelete(int $id): int
    {
        $history = MedicinesHistory::find($id);

        if (!$history) {
            throw new MedicinesHistoryNotFoundException('Not found exception!');
        }

        try {
            $history->delete();
        } catch (\Exception $exception) {
            report($exception);

            return 0;
        }

        return $id;
    }

    public static function getHistory(array $weekData): array
    {
        $data = [];
        $historyData = [];

        $doses = DB::table('medicines')
            ->select('medicines.id',
                'name',
                'unit',
                DB::raw('GROUP_CONCAT(medicines_units.amount) as unit_amount'),
                DB::raw('GROUP_CONCAT(DISTINCT(medicines_doses.amount)) as dose_amount'),
                DB::raw('GROUP_CONCAT(DISTINCT(medicines_doses.schedule)) as schedule')
            )
            ->join('medicines_doses', 'medicines.id', '=', 'medicines_doses.medicines_id')
            ->join('medicines_units', 'medicines.id', '=', 'medicines_units.medicines_id')
            ->groupBy('medicines.id')
            ->get();

        $histories = DB::table('medicines_histories')
            ->select('medicines_histories.medicines_id',
                DB::raw('DATE(time_taken) as date'),
                DB::raw('TIME(time_taken) as time'),
                DB::raw('SUM(medicines_histories.amount) as taken_amount'),
                DB::raw('medicines_doses.amount - SUM(medicines_histories.amount) as left_amount'),
                DB::raw('CEIL((medicines_doses.amount - SUM(medicines_histories.amount)) * 100 / medicines_doses.amount) as left_percent')
            )
            ->join('medicines_doses', 'medicines_doses.id', '=', 'medicines_histories.medicines_id')
            ->groupBy(['date', 'medicines_histories.medicines_id'])
            ->get();

        foreach ($doses as $dose) {
            $id = $dose->id;
            $data[$id] = [
                'name' => $dose->name,
                'schedule' => $dose->schedule,
                'unit_amount' => array_map('floatval', explode(',', $dose->unit_amount)),
                'dose_amount' => (float)$dose->dose_amount,
                'unit' => $dose->unit,
                'history' => []
            ];
        }

        foreach ($histories as $history) {
            $id = $history->medicines_id;
            $date = $history->date;
            $hour = explode(':', $history->time)[0];
            $historyData[$id][$date] = [
                'date' => $history->date,
                'time' => $history->time,
                'hour' => (int)$hour,
                'dose_amount' => $data[$id]['dose_amount'],
                'taken_amount' => $history->taken_amount,
                'left_amount' => $history->left_amount,
                'left_percent' => $history->left_percent
            ];
        }

        foreach ($doses as $dose) {
            $id = $dose->id;
            foreach ($weekData as $week) {
                if (isset($historyData[$id][$week])) {
                    $data[$id]['history'][] = $historyData[$id][$week];
                } else {
                    $data[$id]['history'][] = [
                        'date' => $week,
                        'time' => '00:00:00',
                        'hour' => 0,
                        'dose_amount' => $data[$id]['dose_amount'],
                        'taken_amount' => 0,
                        'left_amount' => $data[$id]['dose_amount'],
                        'left_percent' => 100
                    ];
                }
            }
        }

        return $data;
    }
}
