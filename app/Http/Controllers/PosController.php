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
use stdClass;
class PosController extends Controller
{
    public function Index()
    {
    	
        $product=DB::table('products')
                ->join('categories','products.category_id','categories.id')
                ->select('categories.category_name','products.*')
                ->get();
        $customer = DB::table('customers')->get();
        $category = DB::table('categories')->get();
    	return view('pos',compact('product','customer','category'));
    }


	 public function AddCart(Request $request)
    {
        $data = array();
        $data['id'] =$request->id;
        $data['name'] =$request->name;
        $data['qty'] =$request->qty;
        $data['price'] =$request->price;
        $data['weight'] =$request->weight;

        $content = Cart::content();
        $tempqty=0;
        foreach ($content as $key) {
        	if($key->id==$request->id){
        		$tempqty=$key->qty;
        	}
        }

        $tempqty=$tempqty+$request->qty;

        $product = DB::table('products')->where('id',$request->id)->first();

        $stock = $product->stock;

        $stockleft=$stock-$tempqty;

        if($stockleft>=0){

	        $add = Cart::add($data);

	        if ($add) {
	                    $notification=array(
	                        'message'=>'Product Added To Cart',
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
        }else{
        	 $notification=array(
	                        'message'=>'Product out of stock',
	                        'alert-type'=>'warning'
	                    );
	                    return Redirect()->back()->with($notification);
        }
    }



    public function AddCartBarcode(Request $request)
    {
    	

    	$productInput=DB::table('products')->where('product_code',$request->barcode_input)->first();

    	// echo "<pre>";
    	// print_r($productInput);
    	// exit();

    	if ($productInput == null) {
    		 $notification=array(
	                        'message'=>'Product not selected or Wrong product id. To checkout click on Print bill button.',
	                        'alert-type'=>'warning'
	                    );
	                    return Redirect()->back()->with($notification);
    	}



    	$data = array();
        $data['id'] =$productInput->id;
        $data['name'] =$productInput->product_name;
        $data['qty'] =1;
        $data['price'] =$productInput->selling_price;
        $data['weight'] =1;

        $content = Cart::content();
        $tempqty=0;
        foreach ($content as $key) {
        	if($key->id==$productInput->id){
        		$tempqty=$key->qty;
        	}
        }

        $tempqty=$tempqty+1;

        $product = DB::table('products')->where('id',$productInput->id)->first();

        $stock = $product->stock;

        $stockleft=$stock-$tempqty;

        if($stockleft>=0){

	        $add = Cart::add($data);

	        if ($add) {
	                    $notification=array(
	                        'message'=>'Product Added To Cart',
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
        }else{
        	 $notification=array(
	                        'message'=>'Product out of stock',
	                        'alert-type'=>'warning'
	                    );
	                    return Redirect()->back()->with($notification);
        }



    }




    public function UpdateCart(Request $request,$rowId)
    {
        $up=$request->qty;

        $product = DB::table('products')->where('id',$request->idProduct)->first();

        $stock = $product->stock;

        $stockleft=$stock-$up;

        if($stockleft>=0){
        $update=Cart::update($rowId, $up);
	        if ($update) {
	                    $notification=array(
	                        'message'=>'Product Update To Cart',
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
        }else{
        	$notification=array(
	                        'message'=>'Product out of stock',
	                        'alert-type'=>'warning'
	                    );
	                    return Redirect()->back()->with($notification);
        }
    }


    public function UpdateCartPrice(Request $request,$rowId)
    {
        
        $product = DB::table('products')->where('id',$request->pid)->first();

        $data = array();
        $data['id'] =$product->id;
        $data['name'] =$product->product_name;
        $data['qty'] =1;
        $data['price'] =$request->pri;
        $data['weight'] =1;
        
        // $add = Cart::add($data);




        // $up=$request->pri;

        // echo "<pre>";
        // print_r($data);
        // exit();

        $update=Cart::update($rowId, $data);
        if ($update) {
                    $notification=array(
                        'message'=>'Product Update To Cart',
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


     public function removeCart($rowId)
	    {
	        Cart::remove($rowId);
	        $notification=array(
	            'message'=>'Product remove from Cart',
	            'alert-type'=>'warning'
	        );
	        return Redirect()->back()->with($notification);
	        
	    }


	public function changetaxes()
	{
		$tax = DB::table('taxes')->where('id',1)->first();
		$finaltax=$tax->amount;

		$currency = DB::table('currency')->where('id',1)->first();
		$finalCurrency=$currency->c_name;
		
		return view('edit_tax',compact('finaltax', 'finalCurrency'));
	}

	public function Updatetax(Request $request)
	{
		$validatedData = $request->validate([
        'amount' => 'required|max:255',
    	]);

		$data = array();
    	$data['amount'] = $request->amount;
    	

        $tax=DB::table('taxes')->where('id',1)->update($data);
        if ($tax) {
            $notification=array(
                'message'=>'Update Tax Successful',
                'alert-type'=>'success'
            );
            return Redirect()->route('taxes')->with($notification);

        }else{
            $notification=array(
                'message'=>'Something Went Wrong',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }
	}


	public function UpdateCurrency(Request $request)
	{
		$validatedData = $request->validate([
        'c_name' => 'required|max:255',
    	]);

		$data = array();
    	$data['c_name'] = $request->c_name;
    	

        $currency=DB::table('currency')->where('id',1)->update($data);
        if ($currency) {
            $notification=array(
                'message'=>'Update Currency Successful',
                'alert-type'=>'success'
            );
            return Redirect()->route('taxes')->with($notification);

        }else{
            $notification=array(
                'message'=>'Something Went Wrong',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }
	}



	public function clearCart()
	{
		Cart::destroy();
    	return redirect()->route('pos-page');
	}

	public function HoldCart()
	{
		$customer = DB::table('customers')->get();
    	return view('hold',compact('customer'));
	}


	public function AddCustomer(Request $request)
	{
		$data = array();
		$data['customer_name']=$request->customer_name;
		$data['customer_phone']=$request->customer_phone;

		$success = DB::table('customers')
    		 			  ->insert($data);
    	if ($success) {
    		 		$notification=array(
    		 			'message'=>'Successfully Customer Inserted',
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





	public function PrintBill(Request $request)
	    {

	    	// echo "<pre>";
	     //    print_r($request->all());

	     //    echo "<pre>";
	     //    print_r(Cart::content());

	     //    exit();


	        $request->validate([
	        'customer_id' => 'required','amount_paid' => 'required',],
	        [
	            'customer_id.required'=>'Select A Customer or Add A Customer',
	            'amount_paid.required'=>'Add Paid Amount.',
	        ]);

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
	        $StoreSales=DB::table('sales')->insert($dataSales);

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
		  $invoice->setLogo("public/images/default/ProPic.jpg");   //logo image path
		  $invoice->setColor("#000000");      // pdf color scheme
		  $invoice->setType("Invoice");    // Invoice Type
		  $invoice->setReference("$billCode");   // Reference
		  $invoice->setDate(date('M dS ,Y',time()));   //Billing Date
		  // $invoice->setDate(" ");  
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




	
}
