<?php

namespace App\Exports;

use App\Profit;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;
class ProfitsExport implements FromCollection
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

     /**
    * @return \Illuminate\Support\Collection
    */
     // varible form and to 
     public function __construct(String $from = null , String $to = null)
     {
         $this->from = $from;
         $this->to   = $to;
     }

     //function select data from database 
    public function collection()
    {

    	$customers = DB::table('profits')
                            ->where('created_at','>=',$this->from)->where('created_at','<=', $this->to)
                            ->get();


        return $customers;
    }

     /**
     * @return array
     */
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
             'ID',
             'p_bill_code',
             'p_data',
             'p_total',
             'date',
        ];
    }
}
