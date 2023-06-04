<?php

namespace App\Models;

use App\Exceptions\MedicinesDosesNotFoundException;
use App\Helpers\DateHelper;
use App\Helpers\NumericHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicinesDoses extends Model
{
    use HasFactory;

    const SCHEDULE_EVERYDAY = 'everyday';
    const SCHEDULE_OCCASIONALLY = 'occasionally';
    const MAX_NUMBER_OF_UNIT_TO_SHOW = 2;

    public $timestamps = false;

    public function medicines()
    {
        return $this->belongsTo(Medicines::class);
    }

    public static function getAllSchedules(): array
    {
        return [self::SCHEDULE_EVERYDAY, self::SCHEDULE_OCCASIONALLY];
    }

    public static function getAllActiveCalculated(string $date): iterable
    {
        $doses = MedicinesDoses::where('active', 1)->get();

        foreach ($doses as $dose) {
            $leftAmount = $dose->amount;

            foreach ($dose->medicines->histories as $history) {
                if (DateHelper::isSameDay($date, $history->time_taken)) {
                    $leftAmount -= $history->amount;
                }
            }

            if ($leftAmount < 0) {
                $leftAmount = 0;
            }

            $dose->left_amount = $leftAmount;
            $dose->take_amount = $dose->amount - $leftAmount;
            $dose->left_percent = NumericHelper::calcPercentage($leftAmount, $dose->amount);
        }

        return $doses;
    }

    public static function getUnitsForTake(iterable $units): array
    {
        $options = [];

        foreach ($units as $unit) {
            for ($i = $unit->amount_multiplier; $i <= self::MAX_NUMBER_OF_UNIT_TO_SHOW; $i += $unit->amount_multiplier) {
                $amount = $i * $unit->amount;
                $options[$amount] = $amount . ' ' . $unit->medicines->unit . ' (' . $i . ' ' . $unit->medicines->take_unit . '.)';
            }
        }

        ksort($options);

        return $options;
    }

    public static function tryAddOrUpdate(int $id, array $input): int
    {
        if (!$id) {
            $medicinesDose = new MedicinesDoses();
        }

        if ($id) {
            $medicinesDose = MedicinesDoses::find($id);
        }

        if (!$medicinesDose) {
            throw new MedicinesDosesNotFoundException('Not found exception!');
        }

        try {
            $medicinesDose->medicines_id = $input['medicines_id'];
            $medicinesDose->amount = $input['amount'];
            $medicinesDose->default_unit = $input['default_unit'];
            $medicinesDose->schedule = $input['schedule'];
            $medicinesDose->active = isset($input['active']) ? 1 : 0;
            $medicinesDose->save();
        } catch (\Exception $exception) {
            report($exception);

            return 0;
        }

        return $medicinesDose->id;
    }

    public static function tryDelete(int $id): int
    {
        $medicinesDose = MedicinesDoses::find($id);

        if (!$medicinesDose) {
            throw new MedicinesDosesNotFoundException('Not found exception!');
        }

        try {
            $medicinesDose->delete();
        } catch (\Exception $exception) {
            report($exception);

            return 0;
        }

        return $id;
    }

    public static function prepare(int $medicineId, float $amount, float $defaultUnit, string $schedule, bool|int $active): MedicinesDoses
    {
        $medicinesDose = new MedicinesDoses();
        $medicinesDose->medicines_id = $medicineId;
        $medicinesDose->amount = $amount;
        $medicinesDose->default_unit = $defaultUnit;
        $medicinesDose->schedule = $schedule;
        $medicinesDose->active = (int)$active;
        $medicinesDose->save();

        return $medicinesDose;
    }
}
