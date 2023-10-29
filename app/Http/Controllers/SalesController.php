<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Konekt\PdfInvoice\InvoicePrinter;
use DateTime;


// use Mike42\Escpos\Printer;
// use Mike42\Escpos\EscposImage;
// use Mike42\Escpos\PrintConnectors\FilePrintConnector;
class SalesController extends Controller
{
   public function index()
   {

   	$all_sales= DB::table('sales')
   						->join('customers','sales.id_customer','customers.id')
   						->join('users','sales.id_seller','users.id')
						->select('customers.customer_name','users.name','sales.*')
						->get();

   	// echo "<pre>";
   	// print_r($all_sales);
   	// exit();

   	return view('sales',compact('all_sales'));
   } 

   public function EditSales($id)
   {
   	$editSale = DB::table('sales')
                        ->where('id',$id)
                        ->first();
   	return view('edit_sales',compact('editSale'));

   }

   public function UpdateSales(Request $request,$id)
   {

   	$sale = DB::table('sales')->where('id',$id) ->first();

   	$paid=$sale->amount_paid;
   	// $due=$sale->total_price - $paid;

    $totalPaid = $paid+$request->amount_paying;
    
    if($totalPaid>= $sale->total_price){
      $totalPaid=$sale->total_price;
    }


    $due=$sale->total_price - $totalPaid;

    if($due<=0){
      $due=0;
    }


   	$data = array();
   	$data['products'] = $sale->products;
   	$data['bill_code'] = $sale->bill_code;
   	$data['id_customer'] = $sale->id_customer;
   	$data['id_seller'] = $sale->id_seller;
   	$data['tax'] = $sale->tax;
   	$data['net_price'] = $sale->net_price;
   	$data['total_price'] = $sale->total_price;
   	$data['payment_method'] = $sale->payment_method;
   	$data['amount_paid'] = $totalPaid;
   	$data['amount_due'] = $due;

   	$sales=DB::table('sales')->where('id',$id)->update($data);
                if ($sales) {
                    $notification=array(
                        'message'=>'Update Sales Successful',
                        'alert-type'=>'success'
                    );
                    return Redirect()->back()->with($notification);

                }else{
                    $notification=array(
                        'message'=>'Something Went Wrong',
                        'alert-type'=>'error'
                    );
                    return Redirect()->back()->with($notification);
                }



   	// echo "<pre>";
   	// print_r($data);
   	
   	// exit();

   }


   public function PrintInvoice($id)
   {
    
      $information =DB::table('sales')->where('id',$id)->first();

      $content=json_decode($information->products);


      $saleDate = substr($information->saledate,0,10);
      $saleTime = substr($information->saledate,11,18);
      
      $dueDateStamp = $saleDate;
      $dueDate = new DateTime($dueDateStamp);
      $dueDate->modify('+3 month');
      $dueDate = $dueDate->format('Y-m-d');


      $sellerId = $information->id_seller;
       $getseller = DB::table('users')->where('id',$sellerId)->first(); 

       $customer_id = $information->id_customer;

       $customer = DB::table('customers')->where('id',$customer_id)->first();  

      $money = DB::table('currency')-> select('c_name')->where('id',1)->first();
      $c_name = $money->c_name;
          $size = 'A4';
          $currency = $c_name.' '; 
          $language = 'en';

          $invoice = new InvoicePrinter($size,$currency,$language);


          // $invoice->flipflop();

          /* Header settings */

          $invoice->setLogo("public/images/default/ProPicMin.png");   //logo image path
          // $invoice->setLogo("public/images/default/JTIlogo.png");

          // $invoice->setColor("#007fff");      // pdf color scheme
          $invoice->setColor("#000000");      // pdf color scheme
          $invoice->setType("Invoice");    // Invoice Type
          $invoice->setReference("$information->bill_code");   // Reference
          $invoice->setDate("     ".$saleDate);   //Billing Date
          // $invoice->setTime($saleTime);   //Billing Time
          // $invoice->setDue(" ");     // Due Date
          // $invoice->setFrom(array("Seller Name","Sample Company Name","128 AA Juanita Ave","Glendora , CA 91740"));

          // $invoice->flipflop();

          // $invoice->hideToFromHeaders();

          // $invoice->setFrom(array("$getseller->name","$getseller->email","$getseller->phone"));
          // $invoice->setTo(array("$customer->customer_name","$customer->customer_phone","",""));
          $invoice->setFrom(array("NAME: ".$customer->customer_name,"CONTACT NO: ".$customer->customer_phone,""));
          foreach ($content as $item ) {

            $Description = DB::table('products')->where('id',$item->id)->first();
            // $invoice->addItem("$item->name",$Description->product_description,$item->qty,0,$item->price,0,$item->price*$item->qty);

            $invoice->addItem("$item->name",$Description->product_description,$item->qty,false,$item->price,false,$item->price*$item->qty);
          }
          // $invoice->addItem("AMD Athlon X2DC-7450","2.4GHz/1GB/160GB/SMP-DVD/VB",6,0,580,0,3480);
          // $invoice->addItem("PDC-E5300","2.6GHz/1GB/320GB/SMP-DVD/FDD/VB",4,0,645,0,2580);
          // $invoice->addItem('LG 18.5" WLCD',"",10,0,230,0,2300);
          // $invoice->addItem("HP LaserJet 5200","",1,0,1100,0,1100);
          
          $vatt=DB::table('sales')->select('tax_percent')->where('id',$id)->first();


          $invoice->addTotal("Subtotal",$information->net_price);
          // $invoice->addTotal("VAT ".$vatt->tax_percent."%",$information->tax);
          $invoice->addTotal("Grand Total",$information->total_price,true);
          $invoice->addTotal("Paid",$information->amount_paid);
          $invoice->addTotal("Due",$information->amount_due);
          
          // $invoice->addBadge("Payment Paid");
          // $invoice->addTitle("Bank A/c: Jesan Trade international SDN BHD 21421300056313 Rhb bank.");
          // // $invoice->addParagraph("Bank A/c: Jesan Trade international SDN BHD 21421300056313 Rhb bank.");
          // $invoice->addParagraph(" ");
          // $invoice->addParagraph("...................................                                                                                                                                                   ................................... \nCustomer's signature                                                                                                                                                      Account's signature");



          // $invoice->addParagraph(" ");
          $invoice->addTitle("Terms & Conditions");
          
          $invoice->addParagraph("1) The product comes with......... Limited Warranty\n2) Physically Damaged item will not be include in the warranty\n3) Copy Software won't cover the warranty\n4) The sold products cancellation free of 30% on purchese will be imposed \n    (only applies on fresh condition)\n5) Our services are available from monday to friday");
          
          $invoice->addParagraph(" ");
          $invoice->addParagraph(" ");
          $invoice->addParagraph(" ");
          $invoice->addParagraph("...................................                                                                                                                                                   ................................... \nCustomer's signature                                                                                                                                                      Account's signature");

          $invoice->setFooternote("Developed by oronnokIT");
          
          $invoice->render('example1.pdf','I'); 
          /* I => Display on browser, D => Force Download, F => local path save, S => return document as string */



   }

    public function DeleteSale($id)
    {
        $deleteSale = DB::table('sales')
                        ->where('id',$id)
                        ->first();


      //  echo "<pre>";
      // print_r($id);
      // echo "<pre>";
      // print_r($deleteSale);
      // exit();
        
        $dltSale = DB::table('sales')
                        ->where('id',$id)
                        ->delete();

        if ($dltSale) {
                    $notification=array(
                        'message'=>'Successfully Sale Deleted',
                        'alert-type'=>'success'
                    );
                    return Redirect()->back()->with($notification);

                }else{
                    $notification=array(
                        'message'=>'Something Went Wrong',
                        'alert-type'=>'error'
                    );
                    return Redirect()->back()->with($notification);
                }
    }






//  public function PrintInvoice($id)
//    {
    
//       $information =DB::table('sales')->where('id',$id)->first();

//       $content=json_decode($information->products);


//       $saleDate = substr($information->saledate,0,10);
//       $saleTime = substr($information->saledate,11,18);
      
//       $dueDateStamp = $saleDate;
//       $dueDate = new DateTime($dueDateStamp);
//       $dueDate->modify('+3 month');
//       $dueDate = $dueDate->format('Y-m-d');


//       $sellerId = $information->id_seller;
//        $getseller = DB::table('users')->where('id',$sellerId)->first(); 

//        $customer_id = $information->id_customer;

//        $customer = DB::table('customers')->where('id',$customer_id)->first();  

       

//        $connector = new FilePrintConnector("php://stdout");

//         /* Information for the receipt */
//         $items = array();

//         foreach ($content as $key) {
//           array_push($items,new item($key->name, $key->price));
//         }

//         // echo "<pre>";
//         // print_r($items);
//         // exit();


//         $subtotal = new item('Subtotal', $information->net_price);
//         $tax = new item('A local tax', $information->tax);
//         $total = new item('Total', $information->total_price, true);
//         /* Date is kept the same for testing */
//         // $date = date('l jS \of F Y h:i:s A');
//         $date = $saleDate;

//         /* Start the printer */
//         $logo = EscposImage::load("public/images/default/ProPic.jpg", false);
//         $printer = new Printer($connector);

//         /* Print top logo */
//         $printer -> setJustification(Printer::JUSTIFY_CENTER);
//         $printer -> graphics($logo);

//         /* Name of shop */
//         $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
//         $printer -> text("ExampleMart Ltd.\n");
//         $printer -> selectPrintMode();
//         $printer -> text("Shop No. 42.\n");
//         $printer -> feed();

//         /* Title of receipt */
//         $printer -> setEmphasis(true);
//         $printer -> text("SALES INVOICE\n");
//         $printer -> setEmphasis(false);

//         /* Items */
//         $printer -> setJustification(Printer::JUSTIFY_LEFT);
//         $printer -> setEmphasis(true);
//         $printer -> text(new item('', '$'));
//         $printer -> setEmphasis(false);
//         foreach ($items as $item) {
//             $printer -> text($item);
//         }
//         $printer -> setEmphasis(true);
//         $printer -> text($subtotal);
//         $printer -> setEmphasis(false);
//         $printer -> feed();

//         /* Tax and total */
//         $printer -> text($tax);
//         $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
//         $printer -> text($total);
//         $printer -> selectPrintMode();

//         /* Footer */
//         $printer -> feed(2);
//         $printer -> setJustification(Printer::JUSTIFY_CENTER);
//         $printer -> text("Thank you for shopping at ExampleMart\n");
//         $printer -> text("For trading hours, please visit example.com\n");
//         $printer -> feed(2);
//         $printer -> text($date . "\n");

//         /* Cut the receipt and open the cash drawer */
//         $printer -> cut();
//         $printer -> pulse();

//         $printer -> close();   



//    }




// }


// /* A wrapper to do organise item names & prices into columns */
// class item
// {
//     private $name;
//     private $price;
//     private $dollarSign;

//     public function __construct($name = '', $price = '', $dollarSign = false)
//     {
//         $this -> name = $name;
//         $this -> price = $price;
//         $this -> dollarSign = $dollarSign;
//     }
    
//     public function __toString()
//     {
//         $rightCols = 10;
//         $leftCols = 38;
//         if ($this -> dollarSign) {
//             $leftCols = $leftCols / 2 - $rightCols / 2;
//         }
//         $left = str_pad($this -> name, $leftCols) ;
        
//         $sign = ($this -> dollarSign ? '$ ' : '');
//         $right = str_pad($sign . $this -> price, $rightCols, ' ', STR_PAD_LEFT);
//         return "$left$right\n";
//     }


  public function  DueIndex ()
  {

    $all_sales= DB::table('sales')
              ->join('customers','sales.id_customer','customers.id')
              ->join('users','sales.id_seller','users.id')
              ->select('customers.customer_name','users.name','sales.*')
              ->where('amount_due','>',0)
              ->get();

    // echo "<pre>";
    // print_r($all_sales);
    // exit();

    return view('dues',compact('all_sales'));

  }




}