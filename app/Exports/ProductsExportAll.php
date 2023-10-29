<?php

namespace App\Exports;

use App\Products;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;
class ProductsExportAll implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$products = DB::table('products')
                        ->join('categories','products.category_id','categories.id')
                        ->join('suppliers','products.supplier_id','suppliers.id')
                        ->select('products.id','products.product_name','categories.category_name','suppliers.name','products.product_code','products.product_description','products.photo','products.stock','products.buying_price','products.selling_price','products.sales','products.vat','products.created_at')->get();
        return $products;
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
             'Product',
             'Category',
             'Supplier',
             'Code',
             'Description',
             'Photo',
             'Stock',
             'Buying Price',
             'Selling Price',
             'Sales',
             'VAT',
             'Created At',
        ];
    }
}
