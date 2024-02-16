<?php

namespace App\Console\Commands;

use App\Mail\TicketCode;
use App\Models\Ticket;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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
        $tickets = Ticket::where('issued', true)->where('emailed', false)->get();
        $tickets->each(function ($ticket) {
            // Send the email
            $this->info("Sending ticket to {$ticket->camper->email}");
            Mail::to($ticket->camper->email)->send(new TicketCode($ticket));
            $ticket->emailed = true;
            $ticket->save();
        });
    }
}
