<?php

namespace App\Console\Commands;

use App\Models\NotificationsQueues;
use App\Services\SmsApiService;
use App\Services\TelegramService;
use Illuminate\Console\Command;

class RunNotificationsQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:notifications:queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Notifications Queue';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(TelegramService $telegramService, SmsApiService $smsApiService)
    {
        if (NotificationsQueues::run($telegramService, $smsApiService)) {
            $this->info('Pomyślnie wysłano notyfikacje');

            return Command::SUCCESS;
        }

        $this->error('Błąd przy wysyłaniu notyfikacji!');

        return Command::FAILURE;
    }
}
