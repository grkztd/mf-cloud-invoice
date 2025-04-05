<?php

namespace Grkztd\MfCloud\Laravel\Console\Commands;

use Illuminate\Console\Command;
use Grkztd\MfCloud\Initialization;

class SyncToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mf-invoice:sync-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'MoneyForwardのTokenを継続させる';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        new Initialization();
    }
}
