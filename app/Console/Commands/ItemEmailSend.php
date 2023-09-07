<?php

namespace App\Console\Commands;

use App\Mail\ItemMail;
use App\Models\Item;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ItemEmailSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:item-email-send';

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
        $item = Item::find(1);
        Mail::to($item->user->email)->send(new ItemMail($item));

        return 0;
    }
}
