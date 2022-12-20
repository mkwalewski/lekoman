<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:user {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add user {name} {email} {password}';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $user = User::firstWhere('email', $this->argument('email'));

            if ($user) {
                $this->error('Taki użytkownik już istnieje!');

                return Command::FAILURE;
            }

            $user = new User();
            $user->name = $this->argument('name');
            $user->email = $this->argument('email');
            $user->password = Hash::make($this->argument('password'));
            $user->save();
            $this->info('Pomyślnie dodano użytkownika');
        } catch (\Exception $exception) {
            report($exception);
            $this->error('Błąd przy dodawaniu użytkownika!');

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
