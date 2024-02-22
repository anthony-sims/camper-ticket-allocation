<?php

namespace App\Console\Commands;

use App\Models\Camper;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class AddCampers extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-campers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $campers = $this->ask("Please enter campers email addresses separated by comma");
        $emails = collect(str($campers)->explode(','));

        $emails->each(fn ($email) => [
            $this->info("Creating $email"),
            Camper::firstOrCreate([
                "email" => $email
            ]),
        ]);
    }
}
