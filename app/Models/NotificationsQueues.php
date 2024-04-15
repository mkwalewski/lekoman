<?php

namespace App\Models;

use App\Helpers\DateHelper;
use App\Services\SmsApiService;
use App\Services\TelegramService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string         $service
 * @property string         $message
 * @property \DateTime      $send_at
 * @property boolean        $send
 * @property string|null    $error
 */
class NotificationsQueues extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function schedule(): bool
    {
        try {
            /** @var Notifications $notification */
            $notifications = Notifications::where('active', 1)->get();

            foreach ($notifications as $notification) {
                $dateStart = DateHelper::setDateWithTime($notification->start_at);
                $message = self::prepareMessage($notification->message, $dateStart);
                NotificationsQueues::prepare($notification->service, $message, $dateStart);
                preg_match('#^(\d+)x$#ui', $notification->repeat_count, $matches);

                if ($matches) {
                    $date = $dateStart->copy();
                    $max = (int) $matches[1];
                    for ($i = 1; $i <= $max; $i++) {
                        $date->add($notification->repeat_every);
                        $message = self::prepareMessage($notification->repeated_message, $dateStart);
                        if ($message) {
                            NotificationsQueues::prepare($notification->service, $message, $date);
                        }
                    }
                }
            }
        } catch (\Exception $exception) {
            report($exception);

            return false;
        }

        return true;
    }

    public static function run(TelegramService $telegramService, SmsApiService $smsApiService): bool
    {
        try {
            /** @var NotificationsQueues $queue */
            $status = true;
            $queues = NotificationsQueues::where('send', 0)->where('send_at', '<=', Carbon::now()->toDateTimeString())->get();

            foreach ($queues as $queue) {
                $service = match ($queue->service) {
                    Notifications::SERVICE_TELEGRAM => $telegramService,
                    Notifications::SERVICE_SMSAPI => $smsApiService,
                };
                if ($service->sendMessage($queue->message)) {
                    $queue->send = 1;
                    $queue->save();
                } else {
                    $status = false;
                    $queue->send = -1;
                    $queue->error = $service->getError();
                    $queue->save();
                }
            }
        } catch (\Exception $exception) {
            report($exception);

            return false;
        }

        return  $status;
    }

    private static function prepareMessage(?string $message, Carbon $time): string
    {
        if ($message === null) {
            $message = '';
        }

        if (str_contains($message, '{{time}}')) {
            $message = str_replace('{{time}}', $time->format('H:i'), $message);
        }

        return $message;
    }

    public static function prepare(string $service, string $message, \DateTime $sendAt, bool $send = false): NotificationsQueues
    {
        $queue = new NotificationsQueues();
        $queue->service = $service;
        $queue->message = $message;
        $queue->send_at = $sendAt;
        $queue->send = $send;
        $queue->save();

        return $queue;
    }
}
