<?php

namespace Rutatiina\Qbuks\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SensioLabs\AnsiConverter\AnsiToHtmlConverter;


class QbuksController extends Controller
{
    public function __construct()
    {}

    public function index()
	{
		return view('admin::index');
	}

    public function update(Request $request)
	{
        $converter = new AnsiToHtmlConverter();

        $output=null;
        $retval=null;
        //exec('cd ../ && ls', $output, $retval); 

        /*
        Discovered Package: rutatiina/banking
        Discovered Package: rutatiina/bill
        Discovered Package: rutatiina/contact
        Discovered Package: rutatiina/credit-note
        Discovered Package: rutatiina/debit-note
        Discovered Package: rutatiina/estimate
        Discovered Package: rutatiina/expense
        Discovered Package: rutatiina/financial-accounting
        Discovered Package: rutatiina/globals
        Discovered Package: rutatiina/invoice
        Discovered Package: rutatiina/item
        Discovered Package: rutatiina/journal-entry
        Discovered Package: rutatiina/payment-made
        Discovered Package: rutatiina/payment-received
        Discovered Package: rutatiina/pos
        Discovered Package: rutatiina/purchase-order
        Discovered Package: rutatiina/qbuks
        Discovered Package: rutatiina/retainer-invoice
        Discovered Package: rutatiina/sales-order
        Discovered Package: rutatiina/services
        Discovered Package: rutatiina/tax
        Discovered Package: rutatiina/tenant
        Discovered Package: rutatiina/ui
        Discovered Package: rutatiina/user
        */
        
        //https://stackoverflow.com/questions/16739998/how-to-update-a-single-library-with-composer
        //composer update rutatiina/qbuks
        //composer update vendor/package:2.* vendor/package2:dev-master
        //composer update rutatiina/*

        exec('cd ../ && composer dumpautoload', $output, $retval);
        //echo "Returned with status $retval and output:\n";
        $retvalString = "Returned with status ".$retval."\n";
        $outputString = implode("\n", $output);
        //return implode("<br/>", $output);
        //return $output;

        //send the output to the systrm admin

        return nl2br($retvalString.$converter->convert($outputString));
    }
}
