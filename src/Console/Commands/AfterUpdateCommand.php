<?php

namespace Rutatiina\Qbuks\Console\Commands;

use Illuminate\Console\Command;
use Rutatiina\Bill\Models\Bill;
use Rutatiina\Sales\Models\Sales;
use Rutatiina\POS\Models\POSOrder;
use Illuminate\Support\Facades\Log;
use Rutatiina\Expense\Models\Expense;
use Rutatiina\Invoice\Models\Invoice;
use Rutatiina\Estimate\Models\Estimate;
use Rutatiina\Bill\Models\RecurringBill;
use Rutatiina\Banking\Models\Transaction;
use Rutatiina\DebitNote\Models\DebitNote;
use Rutatiina\CreditNote\Models\CreditNote;
use Rutatiina\SalesOrder\Models\SalesOrder;
use Rutatiina\GoodsIssued\Models\GoodsIssued;
use Rutatiina\PaymentMade\Models\PaymentMade;
use Rutatiina\Expense\Models\RecurringExpense;
use Rutatiina\Invoice\Models\RecurringInvoice;
use Rutatiina\PettyCash\Models\PettyCashEntry;
use Rutatiina\FinancialAccounting\Models\Account;
use Rutatiina\GoodsReceived\Models\GoodsReceived;
use Rutatiina\GoodsReturned\Models\GoodsReturned;
use Rutatiina\PurchaseOrder\Models\PurchaseOrder;
use Rutatiina\GoodsDelivered\Models\GoodsDelivered;
use Rutatiina\PaymentReceived\Models\PaymentReceived;
use Rutatiina\RetainerInvoice\Models\RetainerInvoice;

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
        $this->info("  * Complete.");

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
        $this->info("  * Complete.");

        //Find deleted transactions and mark them as canceled
        $this->info("* Find deleted transactions and mark them as canceled.");
        $tables = [

            //banking
            'rg_banking_transactions' => Transaction::class,

            //pos
            'rg_pos_orders' => POSOrder::class,

            //sales
            'rg_sales' => Sales::class,
            'rg_estimates' => Estimate::class,
            'rg_retainer_invoices' => RetainerInvoice::class,
            'rg_sales_orders' => SalesOrder::class,
            'rg_invoices' => Invoice::class,
            'rg_payments_received' => PaymentReceived::class,
            'rg_recurring_invoices' => RecurringInvoice::class,
            'rg_credit_notes' => CreditNote::class,

            //purchases & expenses
            'rg_petty_cash_entries' => PettyCashEntry::class,
            'rg_expenses' => Expense::class,
            'rg_expense_recurring_expenses' =>RecurringExpense::class,
            'rg_purchase_orders' => PurchaseOrder::class,
            'rg_bills' => Bill::class,
            'rg_payments_made' => PaymentMade::class,
            'rg_bill_recurring_bills' => RecurringBill::class,
            'rg_debit_notes' =>DebitNote::class,

            //inventory
            'rg_goods_received' =>GoodsReceived::class,
            'rg_goods_delivered' => GoodsDelivered::class,
            'rg_goods_issued' => GoodsIssued::class,
            'rg_goods_returned' => GoodsReturned::class,
			
		];

        foreach ($tables as $t => $model) 
        {
            $count = $model::withTrashed()->whereNotNull('deleted_at')->count();
            $this->info("   - Table: ".$t." has ".$count." deleted records.");

            $model::withTrashed()->whereNotNull('deleted_at')->update(['canceled' => 1]);
            
            // $model::withTrashed()->whereNotNull('deleted_at')->restore();
            $model::withTrashed()->whereNotNull('deleted_at')->chunk(500, function ($records) {
                foreach ($records as $record) {
                    $record->restore();
                }
            });
        }
        $this->info("  * Complete.");

        // return 0;
    }
}
