<?php

namespace App\Models;

use App\Exceptions\MoodsHistoryNotFoundException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MoodsHistory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $dates = ['history_time'];

    public function moods()
    {
        return $this->belongsTo(Moods::class);
    }

    public static function getHistory(array $weekData): array
    {
        $data = [];
        $historyData = [];

        $histories = DB::table('moods_histories')
            ->select(
                DB::raw('MIN(moods_id) as moods_id'),
                DB::raw('DATE(history_time) as date'),
                DB::raw('TIME(history_time) as time')
            )
            ->groupBy(['date'])
            ->get();

        foreach ($histories as $history) {
            $date = $history->date;
            $hour = explode(':', $history->time)[0];
            $historyData[$date] = [
                'date' => $history->date,
                'time' => $history->time,
                'hour' => (int)$hour,
                'moods_id' => $history->moods_id
            ];
        }

        foreach ($weekData as $week) {
            if (isset($historyData[$week])) {
                $data[] = $historyData[$week];
            } else {
                $data[] = [
                    'date' => $week,
                    'time' => '00:00:00',
                    'hour' => 0,
                    'moods_id' => 0
                ];
            }
        }

        return $data;
    }

    public static function tryAdd(array $input): int
    {
        $moodHistory = new MoodsHistory();

        try {
            $moodHistory->moods_id = $input['moods_id'];
            $moodHistory->history_time = new Carbon('now');
            $moodHistory->save();
        } catch (\Exception $exception) {
            report($exception);

            return 0;
        }

        return $moodHistory->id;
    }

    public static function tryDelete(int $id): int
    {
        $history = MoodsHistory::find($id);

        if (!$history) {
            throw new MoodsHistoryNotFoundException('Not found exception!');
        }

        try {
            $history->delete();
        } catch (\Exception $exception) {
            report($exception);

            return 0;
        }

        return $id;
    }
}
