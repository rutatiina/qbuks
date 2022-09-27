<?php

namespace Rutatiina\Qbuks\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Rutatiina\FinancialAccounting\Models\Account;

class AfterUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'after-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Changes to be made after the system is updated';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('* After update initiated.');

        $this->info("* Changing 'cost-of-sales' back to 'expense'.");
        Account::withoutGlobalScopes()
            ->where('type', 'cost-of-sales')
            ->update([
                'type' => 'expense',
                'sub_type' => 'cost-of-sales',
            ]);
        $this->info("* Complete.");

        //the script to process recurring requests

        // return 0;
    }
}
