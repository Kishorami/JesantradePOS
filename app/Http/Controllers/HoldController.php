<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
// use Datatables;
use DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Redirect,Response;
use DNS1D;
use Cart;
use Auth;
use Konekt\PdfInvoice\InvoicePrinter;
use DateTime;
use stdClass;

class HoldController extends Controller
{
    public function HoldIndex()
    {
    	$holds = DB::table('holdorders')
   						->join('customers','holdorders.id_customer','customers.id')
   						->join('users','holdorders.id_seller','users.id')
						->select('customers.customer_name','users.name','holdorders.*')
						->get();
        

    	return view('hold_info', compact('holds'));

    }

    public function HoldOrder(Request $request)
    {

		

    	$request->validate([
	    'customer_id' => 'required','amount_paid' => 'required',],
        [
            'customer_id.required'=>'Select A Customer or Add A Customer',
            'amount_paid.required'=>'Add Paid Amount.',
        ]);

      
      // $request->validate([
      //     'amount_paid' => 'required',],
      //     [
      //       'amount_paid.required'=>'Give Paid Amount',
      //     ]
      // ]);

		// echo "<pre>";
  //       print_r($request->all());

  //       echo "<pre>";
  //       print_r(Cart::content());

  //       exit();

    	$customerinfo = explode(':', $request->customer_id);

	        $customerID = $customerinfo[0];

	        $iscustomer = DB::table('customers')->where('id',$customerID)->first();

	        if (empty($iscustomer)) {
	        	return redirect()->route('pos-page');
	        }
	        
	        if (Cart::total() == 0) {
	        	return redirect()->route('pos-page');
	        }

	        $content = Cart::content();

	        //products table stock adjust-----------------------------------------------------
	        foreach ($content as $key) {
	        	$proid=$key->id;

	        	$product = DB::table('products')->where('id',$proid)->first();

	        	$saleqty = $key->qty;

	        	$newstock = $product->stock - $saleqty;
	        	$newSale = $product->sales + $saleqty;

	        	$data=array();
	        	$data['product_name']=$product->product_name;
	        	$data['category_id']=$product->category_id;
	        	$data['supplier_id']=$product->supplier_id;
	        	$data['product_code']=$product->product_code;
	        	$data['product_description']=$product->product_description;
	        	$data['photo']=$product->photo;
	        	$data['stock']=$newstock;
	        	$data['buying_price']=$product->buying_price;
	        	$data['selling_price']=$product->selling_price;
	        	$data['sales']=$newSale;
	        	$data['vat']=$product->vat;


	        	$StockAdjust=DB::table('products')->where('id',$proid)->update($data);

	        	// echo "<pre>";
		        // // print_r("product: ".$data);
		        // print_r($data);
		        
	        }
	        // exit();

	        //Sales table insert---------------------------------------------------------------

	        $billCode=Str::random(8);

	        $sellerId = Auth::id(); 

	        // $carttotal=floatval($request->carttotal);

	        $Totaltax = str_replace(",","",Cart::tax());

	        $subTotal = str_replace(",","",Cart::subtotal());

	        $temp = str_replace(",","",$request->carttotal);
	        $carttotal=floatval($temp);
	        $paid = $request->amount_paid;
	        $amountDue = $carttotal-(float)$paid;

	        $amountChange = 0;

	        if($amountDue <= 0){

	        	$amountChange = $amountDue*(-1);
	        	$amountDue = 0;
	        }


	        $ifChangePaid = $paid - $amountChange;  

	        $taxPercent = DB::table('taxes')->select('amount')->where('id',1)->first();

	        $dataSales=array();

	        if($amountDue <= 0){

		        $dataSales['products']=$content;
		        $dataSales['bill_code']=$billCode;
		        $dataSales['id_customer']=$customerID;
		        $dataSales['id_seller']=$sellerId;
		        $dataSales['tax']=$Totaltax;
		        $dataSales['tax_percent']=$taxPercent->amount;
		        $dataSales['net_price']=$subTotal;
		        $dataSales['total_price']=$carttotal;
		        $dataSales['payment_method']=$request->payment_method;
		        $dataSales['amount_paid']=$ifChangePaid;
		        $dataSales['amount_due']=0.00;

	    	}else{

	    		$dataSales['products']=$content;
		        $dataSales['bill_code']=$billCode;
		        $dataSales['id_customer']=$customerID;
		        $dataSales['id_seller']=$sellerId;
		        $dataSales['tax']=$Totaltax;
		        $dataSales['tax_percent']=$taxPercent->amount;
		        $dataSales['net_price']=$subTotal;
		        $dataSales['total_price']=$carttotal;
		        $dataSales['payment_method']=$request->payment_method;
		        $dataSales['amount_paid']=$paid;
		        $dataSales['amount_due']=$amountDue;

	    	}
	        $StoreSales=DB::table('holdorders')->insert($dataSales);

	        // echo "<pre>";
	        // // print_r("product: ".$data);
	        // print_r($dataSales);
	        // exit();
            
            //product Profit calculation -------------------------------------------------------
	        	$profitJson=array();
	        	$profitObj = new stdClass();

	        	$profit_total = 0;

	        	foreach ($content as $por_p) {
	        		$temp_product = DB::table('products')->where('id',$por_p->id)->first();

	        		$profit_single = $por_p->price - $temp_product->buying_price;
	        		$p_total = 0;
	        		if ($profit_single >=0) {
	        			$p_total = $por_p->qty*$profit_single;
	        		}
	        		

	        		$profitObj->id = $por_p->id;
	        		$profitObj->quantity = $por_p->qty;
	        		$profitObj->buying_price = $temp_product->buying_price;
	        		$profitObj->selling_price = $por_p->price;
	        		$profitObj->profit_total = $p_total;

	        		$myJSON = json_encode($profitObj);

	        		array_push($profitJson, $myJSON);

	        		$profit_total = $profit_total + $p_total;
		        
	        	}

	        	$proJson = json_encode($profitJson);
	        	$profit_data = array();
	        	$profit_data['p_bill_code'] = $billCode;
	        	$profit_data['p_data'] = $proJson;
	        	$profit_data['p_total'] = $profit_total;
	        	$StockAdjust=DB::table('profits')->insert($profit_data);

	        	
	         //product Profit calculation -------------------------------------------------------
            
            
	    //Printing Bill-----------------------------------------------------------------

	      $getseller = DB::table('users')->where('id',$sellerId)->first(); 

	      $customer_id = $customerID;

          $customer = DB::table('customers')->where('id',$customer_id)->first();  

      $money = DB::table('currency')-> select('c_name')->where('id',1)->first();
      $c_name = $money->c_name;

          $size = 'A4';
          $currency = $c_name.' '; 
          $language = 'en';

          $invoice = new InvoicePrinter($size,$currency,$language);

		  /* Header settings */
		  $invoice->setLogo("public/images/default/ProPicMin.png");   //logo image path
		  $invoice->setColor("#000000");      // pdf color scheme
		  $invoice->setType(" Invoice");    // Invoice Type
		  $invoice->setReference("$billCode");   // Reference
		  $invoice->setDate(date('M dS ,Y',time()));   //Billing Date
		  // $invoice->setTime(date('h:i:s A',time()));   //Billing Time
		  // $invoice->setDue(" ");    // Due Date
		  // $invoice->setFrom(array("Seller Name","Sample Company Name","128 AA Juanita Ave","Glendora , CA 91740"));
		  // $invoice->setFrom(array("$getseller->name","$getseller->email","$getseller->phone"));
		  // $invoice->setTo(array("$customer->customer_name","$customer->customer_phone","",""));
		  $invoice->setFrom(array("NAME: ".$customer->customer_name,"CONTACT NO: ".$customer->customer_phone,""));
		  foreach ($content as $item ) {

		  	$Description = DB::table('products')->where('id',$item->id)->first();

		  	$invoice->addItem("$item->name",$Description->product_description,$item->qty,false,$item->price,false,$item->price*$item->qty);
		  }
		  // $invoice->addItem("AMD Athlon X2DC-7450","2.4GHz/1GB/160GB/SMP-DVD/VB",6,0,580,0,3480);
		  // $invoice->addItem("PDC-E5300","2.6GHz/1GB/320GB/SMP-DVD/FDD/VB",4,0,645,0,2580);
		  // $invoice->addItem('LG 18.5" WLCD',"",10,0,230,0,2300);
		  // $invoice->addItem("HP LaserJet 5200","",1,0,1100,0,1100);
		  
		  $vatt=DB::table('taxes')->select('amount')->where('id',1)->first();


		  $invoice->addTotal("Subtotal",Cart::subtotal());
		  // $invoice->addTotal("VAT ".$vatt->amount."%",Cart::tax());
		  $invoice->addTotal("Grand Total",Cart::total(),true);
		  $invoice->addTotal("Paid",$paid);
		  if($amountDue > 0){
		  	$invoice->addTotal("Due",$amountDue);
		  }else{
		  	$invoice->addTotal("Change",$amountChange);
		  }
		  // $invoice->addBadge("Payment Paid");
		   $invoice->addTitle("Terms & Conditions");
          
          $invoice->addParagraph("1) The product comes with......... Limited Warranty\n2) Physically Damaged item will not be include in the warranty\n3) Copy Software won't cover the warranty\n4) The sold products cancellation free of 30% on purchese will be imposed \n    (only applies on fresh condition)\n5) Our services are available from monday to friday");
          
          $invoice->addParagraph(" ");
          $invoice->addParagraph(" ");
          $invoice->addParagraph(" ");
          $invoice->addParagraph("...................................                                                                                                                                                   ................................... \nCustomer's signature                                                                                                                                                      Account's signature");

          // $invoice->setFooternote("Developed by Mackasoft");
          
          $invoice->render('example1.pdf','I'); 
		  /* I => Display on browser, D => Force Download, F => local path save, S => return document as string */



		  Cart::destroy();
    	  return redirect()->route('pos-page');

    }


    public function PrintHolds($id)
   {
    
      $information =DB::table('holdorders')->where('id',$id)->first();

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

          /* Header settings */
          $invoice->setLogo("public/images/default/ProPicMin.png");   //logo image path
          $invoice->setColor("#000000");      // pdf color scheme
          $invoice->setType("Invoice");    // Invoice Type
          $invoice->setReference("$information->bill_code");   // Reference
          $invoice->setDate("     ".$saleDate);   //Billing Date
          // $invoice->setTime($saleTime);   //Billing Time
          // $invoice->setDue(" ");     // Due Date
          // $invoice->setFrom(array("Seller Name","Sample Company Name","128 AA Juanita Ave","Glendora , CA 91740"));
          // $invoice->setFrom(array("$getseller->name","$getseller->email","$getseller->phone"));
          // $invoice->setTo(array("$customer->customer_name","$customer->customer_phone","",""));
          $invoice->setFrom(array("NAME: ".$customer->customer_name,"CONTACT NO: ".$customer->customer_phone,""));
          foreach ($content as $item ) {

            $Description = DB::table('products')->where('id',$item->id)->first();
            
            $invoice->addItem("$item->name",$Description->product_description,$item->qty,false,$item->price,false,$item->price*$item->qty);
          }
          // $invoice->addItem("AMD Athlon X2DC-7450","2.4GHz/1GB/160GB/SMP-DVD/VB",6,0,580,0,3480);
          // $invoice->addItem("PDC-E5300","2.6GHz/1GB/320GB/SMP-DVD/FDD/VB",4,0,645,0,2580);
          // $invoice->addItem('LG 18.5" WLCD',"",10,0,230,0,2300);
          // $invoice->addItem("HP LaserJet 5200","",1,0,1100,0,1100);
          
          $vatt=DB::table('holdorders')->select('tax_percent')->where('id',$id)->first();


          $invoice->addTotal("Subtotal",$information->net_price);
          // $invoice->addTotal("VAT ".$vatt->tax_percent."%",$information->tax);
          $invoice->addTotal("Grand Total",$information->total_price,true);
          $invoice->addTotal("Paid",$information->amount_paid);
          $invoice->addTotal("Due",$information->amount_due);
          
          // $invoice->addBadge("Payment Paid");
           $invoice->addTitle("Terms & Conditions");
          
          $invoice->addParagraph("1) The product comes with......... Limited Warranty\n2) Physically Damaged item will not be include in the warranty\n3) Copy Software won't cover the warranty\n4) The sold products cancellation free of 30% on purchese will be imposed \n    (only applies on fresh condition)\n5) Our services are available from monday to friday");
          
          $invoice->addParagraph(" ");
          $invoice->addParagraph(" ");
          $invoice->addParagraph(" ");
          $invoice->addParagraph("...................................                                                                                                                                                   ................................... \nCustomer's signature                                                                                                                                                      Account's signature");

          // $invoice->setFooternote("Developed by Mackasoft");
          
          $invoice->render('example1.pdf','I'); 
          /* I => Display on browser, D => Force Download, F => local path save, S => return document as string */



   }

   public function EditHold($id)
   {
   	$editHold = DB::table('holdorders')
                        ->where('id',$id)
                        ->first();
   	return view('edit_hold',compact('editHold'));

   }

   public function UpdateHold(Request $request,$id)
   {

   	$sale = DB::table('holdorders')->where('id',$id) ->first();

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

   	$sales=DB::table('holdorders')->where('id',$id)->update($data);
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


   public function DeleteHold($id)
    {
        $deleteHold = DB::table('holdorders')
                        ->where('id',$id)
                        ->first();


      //  echo "<pre>";
      // print_r($id);
      // echo "<pre>";
      // print_r($deleteHold);
      // exit();
        $data = array();
   		$data['products'] = $deleteHold->products;
   		$data['bill_code'] = $deleteHold->bill_code;
   		$data['id_customer'] = $deleteHold->id_customer;
   		$data['id_seller'] = $deleteHold->id_seller;
   		$data['tax'] = $deleteHold->tax;
   		$data['tax_percent'] = $deleteHold->tax_percent;
   		$data['net_price'] = $deleteHold->net_price;
   		$data['total_price'] = $deleteHold->total_price;
   		$data['payment_method'] = $deleteHold->payment_method;
   		$data['amount_paid'] = $deleteHold->amount_paid;
   		$data['amount_due'] = $deleteHold->amount_due;


		$AddToSale=DB::table('sales')->insert($data);


        
        $dltHold = DB::table('holdorders')
                        ->where('id',$id)
                        ->delete();

        if ($dltHold) {
                    $notification=array(
                        'message'=>'Successfully Hold Deleted',
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



}
