<?php

namespace App\Exports;

use App\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;
class CustomersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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

    	$customers = DB::table('customers')
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

    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class    => function(AfterSheet $event) {

    //             // last column as letter value (e.g., D)
    //         $last_column = 'j';

    //         // calculate last row + 1 (total results + header rows + column headings row + new row)
    //         $last_row = 10 + 2 + 1 + 1;

    //         // at row 1, insert 2 rows
    //         $event->sheet->insertNewRowBefore(1, 2);

    //         // merge cells for full-width
    //         $event->sheet->mergeCells(sprintf('A1:%s1',$last_column));
    //         $event->sheet->mergeCells(sprintf('A2:%s2',$last_column));
    //         $event->sheet->mergeCells(sprintf('A%d:%s%d',$last_row,$last_column,$last_row));

    //         // set up a style array for cell formatting
    //         $style_text_center = [
    //             'alignment' => [
    //                 'horizontal'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
    //             ]
    //         ];

    //         $cellRange = 'A1:W1'; // All headers
    //         $event->sheet->setCellValue('A1','APPROVED SELL REPORT FROM '.$this->from.' TO '.$this->from);

    //         $event->sheet->getStyle('A1:A2')->applyFromArray($style_text_center);

    //             $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
    //             $cellRange = 'A3:W3'; // All headers
    //             $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
             
    //         },
    //     ];
    // }
    
    //function header in excel
     public function headings(): array
     {
         return [
             'ID',
             'Name',
             'Contact',
        ];
    }
}
