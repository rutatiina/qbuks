<?php

namespace Rutatiina\Qbuks\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Rutatiina\Banking\Models\Transaction;
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

        $this->info("* Updating bank transactions with 'bank_account_financial_account_code'.");
        //update bank_account_financial_account_code column in the rg_banking_transactions
        $bankTransactions = Transaction::withoutGlobalScopes()
            ->with(['bank_account' => function ($query) {
                $query->withoutGlobalScopes();
            }])
            ->whereNull('bank_account_financial_account_code')
            ->orWhere('bank_account_financial_account_code', '')
            ->distinct('bank_account_id')
            ->groupBy('bank_account_id')
            ->get();
            
        foreach ($bankTransactions as $key => $txn) {
            $bankAccount = $txn->bank_account;
            Transaction::withoutGlobalScopes()
                ->where('bank_account_id', $txn->bank_account_id)
                ->where(function($q){
                    $q->whereNull('bank_account_financial_account_code');
                    $q->orWhere('bank_account_financial_account_code', '');
                })
                ->update([
                    'bank_account_financial_account_code' => $bankAccount->financial_account_code
                ]);
        }
        $this->info("* Complete.");

        // return 0;
    }
}
