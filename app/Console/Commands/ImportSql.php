<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportSql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:sql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import .sql files';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try
        {
            foreach (glob("database/sql/*.sql") as $filename)
            {
                $data = file_get_contents($filename);
                DB::unprepared($data);
            }
            $this->info('Pomyślnie zaimportowano SQL');
        }
        catch (\Exception $exception)
        {
            report($exception);
            $this->error('Błąd przy imporcie SQL');

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
