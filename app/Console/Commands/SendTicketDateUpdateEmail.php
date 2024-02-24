<?php

namespace App\Console\Commands;

use App\Mail\TicketDateUpdate;
use App\Models\Camper;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;

class SendTicketDateUpdateEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-ticket-date-update-email';

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
        $campers = Camper::whereHas('ticket', function (Builder $query) {
            $query->where('issued', true);
        })->get();
        
        // $email = new TicketDateUpdate();
        foreach ($campers as $c) {
            Mail::to($c->email)->send(new TicketDateUpdate());
        }
    }
}
