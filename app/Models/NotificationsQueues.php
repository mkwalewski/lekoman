<?php

namespace App\Models;

use App\Helpers\DateHelper;
use App\Services\TelegramService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string     $message
 * @property \DateTime  $send_at
 * @property boolean    $send
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
                $date = DateHelper::setDateWithTime($notification->start_at);
                $message = self::prepareMessage($notification->message, $date);
                NotificationsQueues::prepare($message, $date);
                preg_match('#^(\d+)x$#ui', $notification->repeat_count, $matches);

                if ($matches) {
                    $max = (int) $matches[1];
                    for ($i = 1; $i <= $max; $i++) {
                        $date->add($notification->repeat_every);
                        $message = self::prepareMessage($notification->repeated_message, $date);
                        NotificationsQueues::prepare($message, $date);
                    }
                }
            }
        } catch (\Exception $exception) {
            report($exception);

            return false;
        }

        return true;
    }

    public static function run(TelegramService $telegramService): bool
    {
        try {
            /** @var NotificationsQueues $queue */
            $queues = NotificationsQueues::where('send', 0)->where('send_at', '<=', Carbon::now()->toDateTimeString())->get();

            foreach ($queues as $queue) {
                if ($telegramService->sendMessage($queue->message)) {
                    $queue->send = 1;
                    $queue->save();
                }
            }
        } catch (\Exception $exception) {
            report($exception);

            return false;
        }

        return  true;
    }

    private static function prepareMessage(string $message, Carbon $time): string
    {
        if (str_contains($message, '{{time}}')) {
            $message = str_replace('{{time}}', $time->format('H:i'), $message);
        }

        return $message;
    }

    public static function prepare(string $message, \DateTime $sendAt, bool $send = false): NotificationsQueues
    {
        $queue = new NotificationsQueues();
        $queue->message = $message;
        $queue->send_at = $sendAt;
        $queue->send = $send;
        $queue->save();

        return $queue;
    }
}
