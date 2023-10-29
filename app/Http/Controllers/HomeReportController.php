<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeReportController extends Controller
{
    public function index(Request $req){

    	$databaseName = "mysql2";

    	$method = $req->method();

        if ($req->isMethod('post'))
        {

        	$From = $req->input('from');
            $To   = $req->input('to');

            // variables to compact----------------------------------------------------------------
            $c_name;
            $salesTotal;
            $allCategories;
            $allCustomers;
            $allProducts;
            $collection;
            $due;
            $refundTotal;
            $holdTotal;
            $expenseTotal;
            $commissionTotal;
            $profit_total;



            // variables to compact----------------------------------------------------------------


	    	$currency = DB::table('currency')-> select('c_name')->where('id',1)->first();

			// echo "<pre>";
			// print_r($currency->c_name);
			// exit();

			$c_name = $currency->c_name;

			// $sales = DB::table('sales')->get();

			$sales = DB::table('sales')
                  ->whereDate('saledate', '>=', date($From))
                  ->whereDate('saledate','<=', date($To))
                  ->get();

			$salesTotal=0;

			$collection=0;

			$due=0;

			foreach ($sales as $key) {
				$salesTotal=floatval($salesTotal)+floatval($key->total_price);

				$collection=floatval($collection)+floatval($key->amount_paid);

				$due=floatval($due)+floatval($key->amount_due);
			}


			//customers---------------------------------------------------------------------------
			$customers = DB::table('customers')
                  ->whereDate('created_at', '>=', date($From))
                  ->whereDate('created_at','<=', date($To))
                  ->get();

			$allCustomers = count($customers);
			//customers---------------------------------------------------------------------------


			//categories---------------------------------------------------------------------------
			$categories =DB::table('categories')
                  ->whereDate('created_at', '>=', date($From))
                  ->whereDate('created_at','<=', date($To))
                  ->get();

			$allCategories = count($categories);
			//categories---------------------------------------------------------------------------

			//products---------------------------------------------------------------------------
			$products = DB::table('products')
                  ->whereDate('created_at', '>=', date($From))
                  ->whereDate('created_at','<=', date($To))
                  ->get();

			$allProducts = count($products);
			//products---------------------------------------------------------------------------

			//refunds---------------------------------------------------------------------------
			$redund = DB::table('refunds')
                  ->whereDate('created_at', '>=', date($From))
                  ->whereDate('created_at','<=', date($To))
                  ->get();

			$refundTotal=0;
			foreach ($redund as $key) {
			  $refundTotal=floatval($refundTotal)+floatval($key->refund_amount);

			  
			}

			//refunds---------------------------------------------------------------------------


			//Hold Orders---------------------------------------------------------------------------
			$hold = DB::table('holdorders')
                  ->whereDate('saledate', '>=', date($From))
                  ->whereDate('saledate','<=', date($To))
                  ->get();


			$holdTotal=0;

			$dueHold=0;

			foreach ($hold as $key) {
			  $holdTotal=floatval($holdTotal)+floatval($key->total_price);
			}
			//Hold Orders---------------------------------------------------------------------------

			//expenses---------------------------------------------------------------------------
			$expenses = DB::table('expenses')
                  ->whereDate('created_at', '>=', date($From))
                  ->whereDate('created_at','<=', date($To))
                  ->get();
			$expenseTotal=0;
			foreach ($expenses as $key) {
			  $expenseTotal=floatval($expenseTotal)+floatval($key->expenses_amount);

			  
			}

			//expenses---------------------------------------------------------------------------

			//commissions---------------------------------------------------------------------------
			$commissions = DB::table('commissions')
                  ->whereDate('created_at', '>=', date($From))
                  ->whereDate('created_at','<=', date($To))
                  ->get();
			$commissionTotal=0;
			foreach ($commissions as $key) {
			  $commissionTotal=floatval($commissionTotal)+floatval($key->commission_amount);

			  
			}
			//commissions---------------------------------------------------------------------------


			//profits---------------------------------------------------------------------------
			$profit_total=0;

			$commissions = DB::table('profits')
                  ->whereDate('created_at', '>=', date($From))
                  ->whereDate('created_at','<=', date($To))
                  ->get();
			foreach ($commissions as $key) {
			  $profit_total=floatval($profit_total)+floatval($key->p_total);

			  
			}

			return view('home_report',compact('c_name', 'salesTotal','allCategories','allCustomers', 'allProducts', 'collection','due','refundTotal','holdTotal','expenseTotal','commissionTotal','profit_total','From','To'));

		}
		else{

				$From = 0;
	            $To   = 0;

	            // variables to compact----------------------------------------------------------------
	            $c_name;
	            $salesTotal;
	            $allCategories;
	            $allCustomers;
	            $allProducts;
	            $collection;
	            $due;
	            $refundTotal;
	            $holdTotal;
	            $expenseTotal;
	            $commissionTotal;
	            $profit_total;
	            $from;
		        $to;



	            // variables to compact----------------------------------------------------------------


		    	$currency = DB::table('currency')-> select('c_name')->where('id',1)->first();

				// echo "<pre>";
				// print_r($currency->c_name);
				// exit();

				$c_name = $currency->c_name;

				// $sales = DB::table('sales')->get();

				$sales = DB::table('sales')
	                  ->get();

				$salesTotal=0;

				$collection=0;

				$due=0;

				foreach ($sales as $key) {
					$salesTotal=floatval($salesTotal)+floatval($key->total_price);

					$collection=floatval($collection)+floatval($key->amount_paid);

					$due=floatval($due)+floatval($key->amount_due);
				}


				//customers---------------------------------------------------------------------------
				$customers = DB::table('customers')
	                  ->get();

				$allCustomers = count($customers);
				//customers---------------------------------------------------------------------------


				//categories---------------------------------------------------------------------------
				$categories =DB::table('categories')
	                  ->get();

				$allCategories = count($categories);
				//categories---------------------------------------------------------------------------

				//products---------------------------------------------------------------------------
				$products = DB::table('products')
	                  ->get();

				$allProducts = count($products);
				//products---------------------------------------------------------------------------

				//refunds---------------------------------------------------------------------------
				$redund = DB::table('refunds')
	                  ->get();

				$refundTotal=0;
				foreach ($redund as $key) {
				  $refundTotal=floatval($refundTotal)+floatval($key->refund_amount);

				  
				}

				//refunds---------------------------------------------------------------------------


				//Hold Orders---------------------------------------------------------------------------
				$hold = DB::table('holdorders')
	                  ->get();


				$holdTotal=0;

				$dueHold=0;

				foreach ($hold as $key) {
				  $holdTotal=floatval($holdTotal)+floatval($key->total_price);
				}
				//Hold Orders---------------------------------------------------------------------------

				//expenses---------------------------------------------------------------------------
				$expenses = DB::table('expenses')
	                  ->get();
				$expenseTotal=0;
				foreach ($expenses as $key) {
				  $expenseTotal=floatval($expenseTotal)+floatval($key->expenses_amount);

				  
				}

				//expenses---------------------------------------------------------------------------

				//commissions---------------------------------------------------------------------------
				$commissions = DB::table('commissions')
	                  ->get();
				$commissionTotal=0;
				foreach ($commissions as $key) {
				  $commissionTotal=floatval($commissionTotal)+floatval($key->commission_amount);

				  
				}
				//commissions---------------------------------------------------------------------------


				//profits---------------------------------------------------------------------------
				$profit_total=0;

				$commissions = DB::table('profits')
	                  ->get();
				foreach ($commissions as $key) {
				  $profit_total=floatval($profit_total)+floatval($key->p_total);

				  
				}

				return view('home_report',compact('c_name', 'salesTotal','allCategories','allCustomers', 'allProducts', 'collection','due','refundTotal','holdTotal','expenseTotal','commissionTotal','profit_total','From','To'));

    		}
		}
}
