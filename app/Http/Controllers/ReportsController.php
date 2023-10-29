<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Exports\ProductsExportAll;
use App\Exports\ProductsExport;
use App\Exports\SalesExport;
use App\Exports\SalesExportAll;
use App\Exports\CustomersExport;
use App\Exports\CustomersExportAll;
use App\Exports\ProfitsExportAll;
use App\Exports\ProfitsExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use PDF;
class ReportsController extends Controller
{
    // Products-------------------------------------------------------------------------------------
    public function Index(Request $req)
    {
        $method = $req->method();

        if ($req->isMethod('post'))
        {


            $tempFrom = $req->input('from');
            $tempTo   = $req->input('to');

            $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
            $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));
            // echo "<pre>";
            // print_r("f: ".$from);
            // echo "<pre>";
            // print_r("t: ".$to);

            // exit();


            if($req->has('exportExcel'))
             {           
                // select Excel
                return Excel::download(new ProductsExport($from, $to), 'Excel-products.xlsx');
            
            } 
        }
        else
        {
            //select all
            $ViewsPage = DB::table('products')
                        ->join('categories','products.category_id','categories.id')
                        ->join('suppliers','products.supplier_id','suppliers.id')
                        ->select('products.id','products.product_name','categories.category_name','suppliers.name','products.product_code','products.product_description','products.photo','products.stock','products.buying_price','products.selling_price','products.sales','products.vat','products.created_at')->get();

            // echo "<pre>";
            // print_r($ViewsPage);
            // exit();


            return view('all_reports',['ViewsPage' => $ViewsPage]);
        }
    }
    
    public function PrintAllProduct()
    {
        return Excel::download(new ProductsExportAll, 'AllProducts.xlsx');
    }

    //Sales report ----------------------------------------------------------------------------------

     public function SalesReport(Request $req)
    {
        $method = $req->method();

        if ($req->isMethod('post'))
        {
            $tempFrom = $req->input('from');
            $tempTo   = $req->input('to');

            $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
            $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));

            if($req->has('exportExcel'))
             {           
                // select Excel
                return Excel::download(new SalesExport($from, $to), 'Excel-sales.xlsx');
            
            } 
        }
        
    }
    
    public function PrintAllSales()
    {
        return Excel::download(new SalesExportAll, 'AllSales.xlsx');
    }


    //Customers report ----------------------------------------------------------------------------------

     public function CustomersReport(Request $req)
    {
        $method = $req->method();

        if ($req->isMethod('post'))
        {
            $tempFrom = $req->input('from');
            $tempTo   = $req->input('to');

            $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
            $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));

            if($req->has('exportExcel'))
             {           
                // select Excel
                return Excel::download(new CustomersExport($from, $to), 'Excel-customers.xlsx');
            
            } 
        }
        
    }
    
    public function PrintAllCustomers()
    {
        return Excel::download(new CustomersExportAll, 'AllCustomers.xlsx');
    }



    //profit reports-------------------------------------------------------------------------------------------
    

     public function ProfitsReport(Request $req)
    {
        $method = $req->method();

        if ($req->isMethod('post'))
        {
            $tempFrom = $req->input('from');
            $tempTo   = $req->input('to');

            $from = date('Y-m-d', strtotime($tempFrom. ' - 1 days'));
            $to   = date('Y-m-d', strtotime($tempTo. ' + 1 days'));

            if($req->has('exportExcel'))
             {           
                // select Excel
                return Excel::download(new ProfitsExport($from, $to), 'Excel-Profits.xlsx');
            
            } 
        }
        
    }


    public function PrintAllProfits()
    {
        return Excel::download(new ProfitsExportAll, 'AllProfits.xlsx');
    }

}
