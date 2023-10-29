<?php

namespace App\Exports;

use App\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;
class SalesExportAll implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $sales = DB::table('sales')
                        ->join('customers','sales.id_customer','customers.id')
                        ->join('users','sales.id_seller','users.id')
                        ->select('sales.id','sales.bill_code','customers.customer_name','users.name','sales.tax','sales.net_price','sales.total_price','sales.payment_method','sales.amount_paid','sales.amount_due','sales.saledate')
                        ->get();


        return $sales;
    }

     public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
    
    //function header in excel
     public function headings(): array
     {
         return [
             'Id',
             'Bill No.',
             'Customer',
             'Seller',
             'Seller',
             'Subtotal',
             'Total',
             'Payment Method',
             'Paid Amount',
             'Due Amount',
             'Sale Date',
        ];
    }
}
