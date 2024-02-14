<?php

namespace App\Console\Commands;

use App\Models\Camper;
use App\Models\Ticket;
use Error;
use Illuminate\Console\Command;

class AllocateTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:allocate-tickets';

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
        $campers = Camper::doesntHave('ticket')->get();
        $campers->each(fn ($camper) => [
            $ticket = Ticket::where('issued', false)->firstOr(fn() => 
                throw new Error("No unallocated tickets")
            ),
            $this->info("Allocating Ticket {$ticket->ticket_code} to {$camper->email}"),
            $camper->ticket()->save($ticket),
            $camper->save(),
            $ticket->issued = true,
            $ticket->save()
        ]);
    }
}
