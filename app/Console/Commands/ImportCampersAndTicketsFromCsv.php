<?php

namespace App\Console\Commands;

use App\Models\Camper;
use App\Models\Ticket;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportCampersAndTicketsFromCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-campers-and-tickets-from-csv';

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
        $campersFile = Storage::get('/seeders/campers.json');
        $campers = collect(json_decode($campersFile));

        $campers->each(fn ($camper) => [
            $this->info("Creating $camper"),
            Camper::firstOrCreate([
                'email' => $camper
            ]),
        ]);

        $ticketsFile = Storage::get('/seeders/tickets.json');
        $tickets = collect(json_decode($ticketsFile));

        $tickets->each(fn ($ticket) => [
            $this->info("Creating Ticket: $ticket"),
            Ticket::firstOrCreate([
                'ticket_code' => $ticket
            ]),
        ]);
    }
}
