<?php

namespace App\Console\Commands;

use App\Models\NotificationsQueues;
use Illuminate\Console\Command;

class ScheduleNotificationsQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:notifications:queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule Notifications Queue';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (NotificationsQueues::schedule()) {
            $this->info('Pomyślnie rozplanowana kolejkę dla notyfikacji');

            return Command::SUCCESS;
        }

        $this->error('Błąd przy rozplanowaniu kolejki dla notyfikacji!');

        return Command::FAILURE;
    }
}
