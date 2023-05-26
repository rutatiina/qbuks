<?php

namespace Rutatiina\Qbuks\Console\Commands;

use Throwable;
use Illuminate\Console\Command;
use Rutatiina\Bill\Models\Bill;
use Rutatiina\Item\Models\Item;
use Rutatiina\Sales\Models\Sales;
use Rutatiina\POS\Models\POSOrder;
use Illuminate\Support\Facades\Log;
use Rutatiina\Tenant\Models\Tenant;
use Rutatiina\Expense\Models\Expense;
use Rutatiina\Invoice\Models\Invoice;
use Rutatiina\POS\Models\POSOrderItem;
use Rutatiina\Estimate\Models\Estimate;
use Spatie\Activitylog\Models\Activity;
use Rutatiina\Bill\Models\RecurringBill;
use Rutatiina\POS\Models\POSOrderLedger;
use Rutatiina\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Builder;
use Rutatiina\Banking\Models\Transaction;
use Rutatiina\DebitNote\Models\DebitNote;
use Rutatiina\Expense\Models\ExpenseItem;
use Rutatiina\Inventory\Models\Inventory;
use Rutatiina\POS\Models\POSOrderItemTax;
use Rutatiina\CreditNote\Models\CreditNote;
use Rutatiina\SalesOrder\Models\SalesOrder;
use Rutatiina\GoodsIssued\Models\GoodsIssued;
use Rutatiina\PaymentMade\Models\PaymentMade;
use Rutatiina\Expense\Models\RecurringExpense;
use Rutatiina\Invoice\Models\RecurringInvoice;
use Rutatiina\PettyCash\Models\PettyCashEntry;
use Rutatiina\FinancialAccounting\Models\Account;
use Rutatiina\GoodsIssued\Models\GoodsIssuedItem;
use Rutatiina\GoodsReceived\Models\GoodsReceived;
use Rutatiina\GoodsReturned\Models\GoodsReturned;
use Rutatiina\PurchaseOrder\Models\PurchaseOrder;
use Rutatiina\GoodsDelivered\Models\GoodsDelivered;
use Rutatiina\GoodsReceived\Models\GoodsReceivedItem;
use Rutatiina\GoodsReturned\Models\GoodsReturnedItem;
use Rutatiina\PaymentReceived\Models\PaymentReceived;
use Rutatiina\RetainerInvoice\Models\RetainerInvoice;
use Rutatiina\GoodsDelivered\Models\GoodsDeliveredItem;
use Rutatiina\Item\Seeders\ItemUnitsOfMeasurementSeeder;
use Rutatiina\Tenant\Scopes\TenantIdScope;

class AfterUpdateCommand extends Command
{
    use TenantTrait;
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
    /*
    public function handle()
    {
        $this->info('* After update initiated.');

        $this->info("* Delete the Discount account");
            Account::withoutGlobalScopes()
                ->where('code', 410500)
                ->forceDelete();
        $this->info("  * Complete.");

        $this->info("* Update the details of the accounts.");
        Tenant::chunk(100, function ($tenants) {
            foreach ($tenants as $tenant) {
                $this->setupFinancialAccounts($tenant->id);
                $this->info("  - Accounts updated for: ".$tenant->name);
            }
        });
        $this->info("  * Complete.");

        $this->info("* Update items billing_financial_account_code");//UPDATE `rg_items` SET `billing_financial_account_code` = '130500' WHERE `id` = '40';
            Item::withoutGlobalScopes()->update(['billing_financial_account_code' => 130500]);
        $this->info("  * Complete.");

        $this->info("* Set the default financial_account_code in rg_inventory to 130500");
            Inventory::withoutGlobalScopes()->update(['financial_account_code' => 130500]);
        $this->info("  * Complete.");

        $this->info("* Set the default inventory_valuation_system, inventory_valuation_method");
            Tenant::withoutGlobalScopes()->update([
                'inventory_valuation_system' => 'perpetual',
                'inventory_valuation_method' => 'fifo'
            ]);
        $this->info("  * Complete.");

        $this->info("* Update Expense items debit_financial_account_code");
            $expenses = Expense::withoutGlobalScopes()
                ->with(['items' => function ($query) {
                    $query->withoutGlobalScopes();
                }])
                ->get();

            foreach($expenses as $expense)
            {
                $this->info("  - Expense #: ".$expense->id);
                foreach ($expense->items as $key => $item) {
                    $this->info("  - Expense-item #: ".$item->id);
                    ExpenseItem::withoutGlobalScopes()->where('id', $item->id)->update([
                        'debit_financial_account_code' => $expense->debit_financial_account_code
                    ]);
                }
            }
        $this->info("  * Complete.");
    }
    //*/


    /*
    Phase out on 15th Oct 2022 because it had been run on both the Shop and Server
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

        //>> Restored the items & ledgers records form activity log for deleted items *****************************

        //get the cancelled or deleted POS orders
        $count = POSOrder::withoutGlobalScopes()
            ->whereDoesntHave('items', function (Builder $query) {
                $query->withoutGlobalScopes();
            })
            ->withTrashed()
            ->count();
        $this->info("* POSOrder has ".$count." records without items.");
        
        //POS Orders
        POSOrder::withoutGlobalScopes()
            ->whereDoesntHave('items', function (Builder $query) {
                $query->withoutGlobalScopes();
            })
            ->withTrashed()
            ->chunk(500, function ($orders) {
                foreach ($orders as $order) {

                    //get the items from the activity log
                    $activityLogs = Activity::where('description', 'created')
                        ->where('subject_type', POSOrderItem::class)
                        ->where(function($q) use ($order){
                            $q->whereJsonContains('properties->attributes->pos_order_id', $order->id);
                            $q->orWhereJsonContains('properties->attributes->pos_order_id', (string) $order->id);
                        })
                        ->get();

                    $this->info("   - #".$order->id." items found in activity log: ".$activityLogs->count());

                    //create the POSOrderItem records
                    $attributes = [];//$activityLogs->first()->properties['attributes'];
                    foreach ($activityLogs as $key => $log) {
                        $attributes[] = $log->properties['attributes'];
                    }
                    POSOrderItem::insert($attributes);


                    //get the taxes from the activity log
                    $activityLogs = Activity::where('description', 'created')
                        ->where('subject_type', POSOrderItemTax::class)
                        ->where(function($q) use ($order){
                            $q->whereJsonContains('properties->attributes->pos_order_id', $order->id);
                            $q->orWhereJsonContains('properties->attributes->pos_order_id', (string) $order->id);
                        })
                        ->get();

                    $this->info("   - #".$order->id." items taxes found in activity log: ".$activityLogs->count());

                    //create the POSOrderItemTax records
                    $attributes = [];
                    foreach ($activityLogs as $key => $log) {
                        $attributes[] = $log->properties['attributes'];
                    }
                    try {
                        POSOrderItemTax::insert($attributes);
                    } catch(Throwable $e) {
                        //do nothing
                    }


                    //get the ledgers from the activity log
                    $activityLogs = Activity::where('description', 'created')
                        ->where('subject_type', POSOrderLedger::class)
                        ->where(function($q) use ($order){
                            $q->whereJsonContains('properties->attributes->pos_order_id', $order->id);
                            $q->orWhereJsonContains('properties->attributes->pos_order_id', (string) $order->id);
                        })
                        ->get();

                    $this->info("   - #".$order->id." ledger found in activity log: ".$activityLogs->count());

                    //create the POSOrderLedger records
                    $attributes = [];
                    foreach ($activityLogs as $key => $log) {
                        $attributes[] = $log->properties['attributes'];
                    }
                    POSOrderLedger::insert($attributes);


                }
            });

        //Goods received
        $count = GoodsReceived::withoutGlobalScopes()
            ->whereDoesntHave('items', function (Builder $query) {
                $query->withoutGlobalScopes();
            })
            ->withTrashed()
            ->count();
        $this->info("* Goods received has ".$count." records without items.");

        GoodsReceived::withoutGlobalScopes()
        ->whereDoesntHave('items', function (Builder $query) {
            $query->withoutGlobalScopes();
        })
        ->withTrashed()
        ->chunk(500, function ($orders) {
            foreach ($orders as $order) {

                //get the items from the activity log
                $activityLogs = Activity::where('description', 'created')
                    ->where('subject_type', GoodsReceivedItem::class)
                    ->where(function($q) use ($order){
                        $q->whereJsonContains('properties->attributes->goods_received_id', $order->id);
                        $q->orWhereJsonContains('properties->attributes->goods_received_id', (string) $order->id);
                    })
                    ->get();

                $this->info("   - GR#".$order->id." items found in activity log: ".$activityLogs->count());

                //create the POSOrderItem records
                $attributes = [];//$activityLogs->first()->properties['attributes'];
                foreach ($activityLogs as $key => $log) {
                    $attributes[] = $log->properties['attributes'];
                }
                GoodsReceivedItem::insert($attributes);

            }
        });


        //Goods delivered
        $count = GoodsDelivered::withoutGlobalScopes()
            ->whereDoesntHave('items', function (Builder $query) {
                $query->withoutGlobalScopes();
            })
            ->withTrashed()
            ->count();
        $this->info("* Goods delivered has ".$count." records without items.");

        GoodsDelivered::withoutGlobalScopes()
        ->whereDoesntHave('items', function (Builder $query) {
            $query->withoutGlobalScopes();
        })
        ->withTrashed()
        ->chunk(500, function ($orders) {
            foreach ($orders as $order) {

                //get the items from the activity log
                $activityLogs = Activity::where('description', 'created')
                    ->where('subject_type', GoodsDeliveredItem::class)
                    ->where(function($q) use ($order){
                        $q->whereJsonContains('properties->attributes->goods_delivered_id', $order->id);
                        $q->orWhereJsonContains('properties->attributes->goods_delivered_id', (string) $order->id);
                    })
                    ->get();

                $this->info("   - #".$order->id." items found in activity log: ".$activityLogs->count());

                //create the POSOrderItem records
                $attributes = [];//$activityLogs->first()->properties['attributes'];
                foreach ($activityLogs as $key => $log) {
                    $attributes[] = $log->properties['attributes'];
                }
                GoodsDeliveredItem::insert($attributes);

            }
        });


        //Goods issued
        $count = GoodsIssued::withoutGlobalScopes()
            ->whereDoesntHave('items', function (Builder $query) {
                $query->withoutGlobalScopes();
            })
            ->withTrashed()
            ->count();
        $this->info("* Goods issued has ".$count." records without items.");

        GoodsIssued::withoutGlobalScopes()
        ->whereDoesntHave('items', function (Builder $query) {
            $query->withoutGlobalScopes();
        })
        ->withTrashed()
        ->chunk(500, function ($orders) {
            foreach ($orders as $order) {

                //get the items from the activity log
                $activityLogs = Activity::where('description', 'created')
                    ->where('subject_type', GoodsIssuedItem::class)
                    ->where(function($q) use ($order){
                        $q->whereJsonContains('properties->attributes->goods_issued_id', $order->id);
                        $q->orWhereJsonContains('properties->attributes->goods_issued_id', (string) $order->id);
                    })
                    ->get();

                $this->info("   - #".$order->id." items found in activity log: ".$activityLogs->count());

                //create the POSOrderItem records
                $attributes = [];//$activityLogs->first()->properties['attributes'];
                foreach ($activityLogs as $key => $log) {
                    $attributes[] = $log->properties['attributes'];
                }
                GoodsIssuedItem::insert($attributes);

            }
        });


        //Goods returned
        $count = GoodsReturned::withoutGlobalScopes()
            ->whereDoesntHave('items', function (Builder $query) {
                $query->withoutGlobalScopes();
            })
            ->withTrashed()
            ->count();
        $this->info("* Goods returned has ".$count." records without items.");

        GoodsReturned::withoutGlobalScopes()
        ->whereDoesntHave('items', function (Builder $query) {
            $query->withoutGlobalScopes();
        })
        ->withTrashed()
        ->chunk(500, function ($orders) {
            foreach ($orders as $order) {

                //get the items from the activity log
                $activityLogs = Activity::where('description', 'created')
                    ->where('subject_type', GoodsReturnedItem::class)
                    ->where(function($q) use ($order){
                        $q->whereJsonContains('properties->attributes->goods_returned_id', $order->id);
                        $q->orWhereJsonContains('properties->attributes->goods_returned_id', (string) $order->id);
                    })
                    ->get();

                $this->info("   - #".$order->id." items found in activity log: ".$activityLogs->count());

                //create the POSOrderItem records
                $attributes = [];//$activityLogs->first()->properties['attributes'];
                foreach ($activityLogs as $key => $log) {
                    $attributes[] = $log->properties['attributes'];
                }
                GoodsReturnedItem::insert($attributes);

            }
        });

        //<<Restored the items & ledgers records form activity log for deleted items *****************************

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
            $count = $model::withoutGlobalScopes()->withTrashed()->whereNotNull('deleted_at')->count();
            $this->info("   - Table: ".$t." has ".$count." deleted records.");

            $model::withoutGlobalScopes()->withTrashed()->whereNotNull('deleted_at')->update(['canceled' => 1]);
            
            // $model::withTrashed()->whereNotNull('deleted_at')->restore();
            $model::withoutGlobalScopes()->withTrashed()->whereNotNull('deleted_at')->chunk(500, function ($records) {
                foreach ($records as $record) {
                    $record->restore();
                    $this->info("   - #".$record->id." restored.");
                }
            });
        }
        $this->info("  * Complete.");

        // return 0;
    }
    */

    //Find out why this code was written
    /*
    public function handle()
    {
        $this->info('* After update initiated.');

        $this->info("* Create Tenant Units of Measurements");
        //php artisan db:seed --class=\\Rutatiina\\Item\\Seeders\\ItemUnitsOfMeasurementSeeder
        $this->call('db:seed', ['--class' => ItemUnitsOfMeasurementSeeder::class]);
        $this->info("  * Complete.");

    
        // return 0;
    }
    //*/

    /*
    // run on qbuks.com
    public function handle()
    {
        $this->info('* After update initiated.');

        $classes = [
            \Rutatiina\GoodsDelivered\Models\GoodsDeliveredSetting::class,
            \Rutatiina\GoodsIssued\Models\GoodsIssuedSetting::class,
            \Rutatiina\GoodsReceived\Models\GoodsReceivedSetting::class,
            \Rutatiina\GoodsReturned\Models\GoodsReturnedSetting::class,
            \Rutatiina\Sales\Models\SalesSetting::class
        ];

        foreach (Tenant::all() as $tenant)
        {
            $this->info('- Cleaning settings records for :: #'.$tenant->id.' > '.$tenant->name);

            foreach($classes as $class)
            {
                $settings = $class::withoutGlobalScopes()->where('tenant_id', $tenant->id)->first();
                if ($settings) $class::withoutGlobalScopes()->whereNotIn('id', [$settings->id])->forceDelete();
            }
        }

        $this->info('############## Now running the DocumentNumbersSeeder seeder #############');

        $this->call('db:seed', ['--class' => \Rutatiina\Sales\Seeders\DocumentNumbersSeeder::class]);
    }
    //*/

    public function handle()
    {
        $this->info("* Re-evaluating balances");

        //truncate all the balances
        \Rutatiina\FinancialAccounting\Models\AccountBalance::truncate();
        \Rutatiina\FinancialAccounting\Models\AccountDailyBalance::truncate();

        //truncate the contact balances
        \Rutatiina\FinancialAccounting\Models\ContactBalance::truncate();

        //truncate the item balances
        \Rutatiina\FinancialAccounting\Models\ItemBalance::truncate();


        //POS
        \Rutatiina\POS\Models\POSOrder::withoutGlobalScopes([TenantIdScope::class])
        ->with(['items' => function ($query) {
            $query->withoutGlobalScopes([TenantIdScope::class]);
        }])
        ->chunk(500, function ($txns) 
        {
            foreach ($txns as $txn) 
            {
                //Update the account balances
                \Rutatiina\FinancialAccounting\Services\AccountBalanceUpdateService::doubleEntry($txn);

                //Update the contact balances
                \Rutatiina\FinancialAccounting\Services\ContactBalanceUpdateService::doubleEntry($txn);

                //Update the item balances
                \Rutatiina\FinancialAccounting\Services\ItemBalanceUpdateService::entry($txn);
            }
        });
        $this->info('- POS balances updated');

        //sales
        \Rutatiina\Sales\Models\Sales::withoutGlobalScopes([TenantIdScope::class])
        ->with(['items' => function ($query) {
            $query->withoutGlobalScopes([TenantIdScope::class]);
        }])
        ->chunk(500, function ($txns) 
        {
            foreach ($txns as $txn) 
            {
                $txn->balances_where_updated = 0;
                $this->info('   - Sales #'.$txn->id);

                //Update the account balances
                \Rutatiina\FinancialAccounting\Services\AccountBalanceUpdateService::doubleEntry($txn);

                //Update the contact balances
                \Rutatiina\FinancialAccounting\Services\ContactBalanceUpdateService::doubleEntry($txn);

                //Update the item balances
                \Rutatiina\FinancialAccounting\Services\ItemBalanceUpdateService::entry($txn);
            }
        });
        $this->info('- Sales balances updated');
       //*/

        //estimates - has custom balance table

        //retainer invoice
        \Rutatiina\RetainerInvoice\Models\RetainerInvoice::withoutGlobalScopes([TenantIdScope::class])
        ->with(['items' => function ($query) {
            $query->withoutGlobalScopes([TenantIdScope::class]);
        }])
        ->chunk(500, function ($txns) 
        {
            foreach ($txns as $txn) 
            {
                //Update the account balances
                \Rutatiina\FinancialAccounting\Services\AccountBalanceUpdateService::doubleEntry($txn);

                //Update the contact balances
                \Rutatiina\FinancialAccounting\Services\ContactBalanceUpdateService::doubleEntry($txn);

                //Update the item balances
                \Rutatiina\FinancialAccounting\Services\ItemBalanceUpdateService::entry($txn);
            }
        });
        $this->info('- Retainer invoice balances updated');

        //sales order - has custom balance table

        //invoices
        \Rutatiina\Invoice\Models\Invoice::withoutGlobalScopes([TenantIdScope::class])
        ->with(['items' => function ($query) {
            $query->withoutGlobalScopes([TenantIdScope::class]);
        }])
        ->chunk(500, function ($txns) 
        {
            foreach ($txns as $txn) 
            {
                //Update the account balances
                \Rutatiina\FinancialAccounting\Services\AccountBalanceUpdateService::doubleEntry($txn);

                //Update the contact balances
                \Rutatiina\FinancialAccounting\Services\ContactBalanceUpdateService::doubleEntry($txn);

                //Update the item balances
                \Rutatiina\FinancialAccounting\Services\ItemBalanceUpdateService::entry($txn);
            }
        });
        $this->info('- Invoice balances updated');

        //payments received
        \Rutatiina\PaymentReceived\Models\PaymentReceived::withoutGlobalScopes([TenantIdScope::class])
        ->with(['items' => function ($query) {
            $query->withoutGlobalScopes([TenantIdScope::class]);
        }])
        ->chunk(500, function ($txns) 
        {
            foreach ($txns as $txn) 
            {
                //Update the account balances
                \Rutatiina\FinancialAccounting\Services\AccountBalanceUpdateService::doubleEntry($txn);

                //Update the contact balances
                \Rutatiina\FinancialAccounting\Services\ContactBalanceUpdateService::doubleEntry($txn);
            }
        });
        $this->info('- Payment received balances updated');

        //recurring invoice - NA - balances are not updated for these

        //credit notes
        \Rutatiina\CreditNote\Models\CreditNote::withoutGlobalScopes([TenantIdScope::class])
        ->with(['items' => function ($query) {
            $query->withoutGlobalScopes([TenantIdScope::class]);
        }])
        ->chunk(500, function ($txns) 
        {
            foreach ($txns as $txn) 
            {
                //Update the account balances
                \Rutatiina\FinancialAccounting\Services\AccountBalanceUpdateService::doubleEntry($txn);

                //Update the contact balances
                \Rutatiina\FinancialAccounting\Services\ContactBalanceUpdateService::doubleEntry($txn);

                //Update the item balances
                \Rutatiina\FinancialAccounting\Services\ItemBalanceUpdateService::entry($txn);
            }
        });
        $this->info('- Credit note balances updated');

        //petty cash
        \Rutatiina\PettyCash\Models\PettyCashEntry::withoutGlobalScopes([TenantIdScope::class])
        ->chunk(500, function ($txns) 
        {
            foreach ($txns as $txn) 
            {
                //Update the account balances
                \Rutatiina\FinancialAccounting\Services\AccountBalanceUpdateService::doubleEntry($txn);

                //Update the contact balances
                \Rutatiina\FinancialAccounting\Services\ContactBalanceUpdateService::doubleEntry($txn);
            }
        });
        $this->info('- Petty cash balances updated');

        //expenses
        \Rutatiina\Expense\Models\Expense::withoutGlobalScopes([TenantIdScope::class])
        ->with(['items' => function ($query) {
            $query->withoutGlobalScopes([TenantIdScope::class]);
        }])
        ->chunk(500, function ($txns) 
        {
            foreach ($txns as $txn) 
            {
                //Update the account balances
                \Rutatiina\FinancialAccounting\Services\AccountBalanceUpdateService::doubleEntry($txn);

                //Update the contact balances
                \Rutatiina\FinancialAccounting\Services\ContactBalanceUpdateService::doubleEntry($txn);

                //Update the item balances
                \Rutatiina\FinancialAccounting\Services\ItemBalanceUpdateService::entry($txn);
            }
        });
        $this->info('- Expense balances updated');

        //recurring expense - NA - balances are not updated for these

        //purchase order
        \Rutatiina\PurchaseOrder\Models\PurchaseOrder::withoutGlobalScopes([TenantIdScope::class])
        ->with(['items' => function ($query) {
            $query->withoutGlobalScopes([TenantIdScope::class]);
        }])
        ->chunk(500, function ($txns) 
        {
            foreach ($txns as $txn) 
            {
                //Update the account balances
                \Rutatiina\FinancialAccounting\Services\AccountBalanceUpdateService::singleEntry($txn);

                //Update the contact balances
                \Rutatiina\FinancialAccounting\Services\ContactBalanceUpdateService::singleEntry($txn);

                //Update the item balances
                \Rutatiina\FinancialAccounting\Services\ItemBalanceUpdateService::entry($txn);
            }
        });
        $this->info('- Purchase order balances updated');

        //bills
        \Rutatiina\Bill\Models\Bill::withoutGlobalScopes([TenantIdScope::class])
        ->with(['items' => function ($query) {
            $query->withoutGlobalScopes([TenantIdScope::class]);
        }])
        ->chunk(500, function ($txns) 
        {
            foreach ($txns as $txn) 
            {
                //Update the account balances
                \Rutatiina\FinancialAccounting\Services\AccountBalanceUpdateService::doubleEntry($txn);

                //Update the contact balances
                \Rutatiina\FinancialAccounting\Services\ContactBalanceUpdateService::doubleEntry($txn);

                //Update the item balances
                \Rutatiina\FinancialAccounting\Services\ItemBalanceUpdateService::entry($txn);
            }
        });
        $this->info('- Bill balances updated');

        //payments made
        \Rutatiina\PaymentMade\Models\PaymentMade::withoutGlobalScopes([TenantIdScope::class])
        ->with(['items' => function ($query) {
            $query->withoutGlobalScopes([TenantIdScope::class]);
        }])
        ->chunk(500, function ($txns) 
        {
            foreach ($txns as $txn) 
            {
                //Update the account balances
                \Rutatiina\FinancialAccounting\Services\AccountBalanceUpdateService::doubleEntry($txn);

                //Update the contact balances
                \Rutatiina\FinancialAccounting\Services\ContactBalanceUpdateService::doubleEntry($txn);
            }
        });
        $this->info('- Payment made balances updated');

        //recurring bills - NA - balances are not updated for these

        //bebit notes
        \Rutatiina\DebitNote\Models\DebitNote::withoutGlobalScopes([TenantIdScope::class])
        ->with(['items' => function ($query) {
            $query->withoutGlobalScopes([TenantIdScope::class]);
        }])
        ->chunk(500, function ($txns) 
        {
            foreach ($txns as $txn) 
            {
                //Update the account balances
                \Rutatiina\FinancialAccounting\Services\AccountBalanceUpdateService::doubleEntry($txn);

                //Update the contact balances
                \Rutatiina\FinancialAccounting\Services\ContactBalanceUpdateService::doubleEntry($txn);

                //Update the item balances
                \Rutatiina\FinancialAccounting\Services\ItemBalanceUpdateService::entry($txn);
            }
        });
        $this->info('- Debit Note balances updated');

        $this->info("  * Complete.");
    }
}
