<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;

class SendTicketEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-ticket-emails';

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
        $tickets = Ticket::where('issued', true)->get();
        $tickets->each(function ($ticket) {
            // Send the email
            $ticket->issued = true;
            $ticket->save();
        });
    }
}
