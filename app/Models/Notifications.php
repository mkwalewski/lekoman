<?php

namespace App\Models;

use App\Exceptions\NotificationsNotFoundException;
use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    const SCHEDULE_EVERYDAY = 'everyday';

    public $timestamps = false;

    public static function getAllSchedules(): array
    {
        return [self::SCHEDULE_EVERYDAY];
    }

    public static function tryAddOrUpdate(int $id, mixed $input): int
    {
        if (!$id) {
            $notification = new Notifications();
        }

        if ($id) {
            $notification = Notifications::find($id);
        }

        if (!$notification) {
            throw new NotificationsNotFoundException('Not found exception!');
        }

        try {
            $notification->schedule = $input['schedule'];
            $notification->start_at = DateHelper::setDateWithTime($input['start_at']);
            $notification->end_at = DateHelper::setDateWithTime($input['end_at']);
            $notification->repeat_every = $input['repeat_every'];
            $notification->repeat_count = $input['repeat_count'];
            $notification->message = $input['message'];
            $notification->repeated_message = $input['repeated_message'];
            $notification->active = isset($input['active']) ? 1 : 0;
            $notification->save();
        } catch (\Exception $exception) {
            report($exception);

            return 0;
        }

        return $notification->id;
    }

    public static function tryDelete(int $id): int
    {
        $notification = Notifications::find($id);

        if (!$notification) {
            throw new NotificationsNotFoundException('Not found exception!');
        }

        try {
            $notification->delete();
        } catch (\Exception $exception) {
            report($exception);

            return 0;
        }

        return $id;
    }
}
