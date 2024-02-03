<?php

namespace App\Models;

use App\Exceptions\NotificationsNotFoundException;
use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string           $service
 * @property string           $schedule
 * @property \DateTime        $start_at
 * @property \DateTime|null   $end_at
 * @property string           $repeat_every
 * @property string           $repeat_count
 * @property string           $message
 * @property string|null      $repeated_message
 * @property boolean          $active
 */
class Notifications extends Model
{
    use HasFactory;

    const SCHEDULE_EVERYDAY = 'everyday';
    const SERVICE_TELEGRAM = 'telegram';
    const SERVICE_SMSAPI = 'smsapi';

    public $timestamps = false;

    public static function getAllSchedules(): array
    {
        return [self::SCHEDULE_EVERYDAY];
    }

    public static function getAllServices()
    {
        return [
            self::SERVICE_TELEGRAM,
            self::SERVICE_SMSAPI,
        ];
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
            $notification->service = $input['service'];
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
