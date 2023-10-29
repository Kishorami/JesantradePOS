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
class ProductController extends Controller
{
	
	public function index(Request $request)
	{
		if ($request->ajax()) {
		$data = Product::latest()->get();
		return Datatables::of($data)
		 // ->editColumn('stock', function($row){

		 // 	$stock = "";
   //              if($row->stock <= 10){
   //                  $stock = '<a class="btn btn-danger btn-sm">'.$row->stock.'</a>';
   //              }
   //              elseif($row->stock > 11 && $row->stock <= 15){
   //                  $stock = '<a class="btn btn-warning btn-sm">'.$row->stock.'</a>';
   //              }
   //              else{
   //                  $stock = '<a class="btn btn-success btn-sm">'.$row->stock.'</a>';
   //              }
   //              return $stock;

   //              return $stock;
   //          })


		->addIndexColumn()
		->addColumn('action', function($row){

		$action = '<a title="View" class="btn btn-info btn-sm" id="show-product" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-info"></i></a>
		<a title="Print Barcode" class="btn btn-info btn-sm" id="print-product" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-print"></i></a>
		<a title="Edit" class="btn btn-warning btn-sm" id="edit-product" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i></a>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<a title="Delete" id="delete-product" data-id='.$row->id.' class="btn btn-danger delete-product btn-sm"><i class="fas fa-trash"></i></a>';

		return $action;

		})
		->rawColumns(['action'])
		->make(true);
		}

		return view('products');
	}


	public function store(Request $request)
	{
		$default_image_url='public/images/default/ProPic.jpg';
		$sId = $request->id;

		$image = $request->file('photo');

		if (!$image){
			if(empty($request->id)){
				$validatedData = $request->validate([
			    
			    'product_code' => 'required|unique:products',
			    
				]);
				$image_url=$default_image_url;
				product::updateOrCreate(['id' => $sId],['product_name' => $request->product_name, 
												'category_id' => $request->category_id,
												'supplier_id' => $request->supplier_id,
												'product_code' => $request->product_code,
												'product_description' => $request->product_description,
												'photo' => $image_url,
												'stock' => $request->stock,
												'buying_price' => $request->buying_price,
												'selling_price' => $request->selling_price,
												'sales' => $request->sales,
												'vat' => $request->vat]);
			}else{

				$Productinfo = DB::table('products')
                        ->where('id',$sId)
                        ->first();
                $imageinfo = $Productinfo->photo;
                if($imageinfo==$default_image_url){
                	product::updateOrCreate(['id' => $sId],['product_name' => $request->product_name, 
												'category_id' => $request->category_id,
												'supplier_id' => $request->supplier_id,
												'product_code' => $request->product_code,
												'product_description' => $request->product_description,
												'photo' => $imageinfo,
												'stock' => $request->stock,
												'buying_price' => $request->buying_price,
												'selling_price' => $request->selling_price,
												'sales' => $request->sales,
												'vat' => $request->vat]);
                }else{
                	product::updateOrCreate(['id' => $sId],['product_name' => $request->product_name, 
												'category_id' => $request->category_id,
												'supplier_id' => $request->supplier_id,
												'product_code' => $request->product_code,
												'product_description' => $request->product_description,
												'photo' => $imageinfo,
												'stock' => $request->stock,
												'buying_price' => $request->buying_price,
												'selling_price' => $request->selling_price,
												'sales' => $request->sales,
												'vat' => $request->vat]);
                }
			}
    		
    	}else{
    		if(empty($request->id)){
    			$validatedData = $request->validate([
			    
			    'product_code' => 'required|unique:products',
			    
				]);

    			
    			$image_name=Str::random(10);
	    		$ext=strtolower($image->getClientOriginalExtension());
	    		$image_full_name=$image_name.'.'.$ext;
	    		$upload_path='public/images/products/';
	    		$image_url=$upload_path.$image_full_name;
					
					// if($image){
					// echo "<pre>";
					// echo "here i am:   ";
			  //   	print_r($image_url);
			  //   	print_r($image);
			  //   	exit();}

	    		$success=$image->move($upload_path,$image_full_name);
	    		if ($success) {
	    			Product::updateOrCreate(['id' => $sId],['product_name' => $request->product_name, 
													'category_id' => $request->category_id,
													'supplier_id' => $request->supplier_id,
													'product_code' => $request->product_code,
													'product_description' => $request->product_description,
													'photo' => $image_url,
													'stock' => $request->stock,
													'buying_price' => $request->buying_price,
													'selling_price' => $request->selling_price,
													'sales' => $request->sales,
													'vat' => $request->vat]);
	    		}
    		}else{
    			$Productinfo = DB::table('products')
                        ->where('id',$sId)
                        ->first();
                $imageinfo = $Productinfo->photo;
                if($imageinfo==$default_image_url){
                	$image_name=Str::random(10);
		    		$ext=strtolower($image->getClientOriginalExtension());
		    		$image_full_name=$image_name.'.'.$ext;
		    		$upload_path='public/images/products/';
		    		$image_url=$upload_path.$image_full_name;
		    		$success=$image->move($upload_path,$image_full_name);
		    		if ($success) {
		    			Product::updateOrCreate(['id' => $sId],['product_name' => $request->product_name, 
													'category_id' => $request->category_id,
													'supplier_id' => $request->supplier_id,
													'product_code' => $request->product_code,
													'product_description' => $request->product_description,
													'photo' => $image_url,
													'stock' => $request->stock,
													'buying_price' => $request->buying_price,
													'selling_price' => $request->selling_price,
													'sales' => $request->sales,
													'vat' => $request->vat]);
		    		}
                }else{
                	$image_name=Str::random(10);
		            $ext=strtolower($image->getClientOriginalExtension());
		            $image_full_name=$image_name.'.'.$ext;
		            $upload_path='public/images/products/';
		            $image_url=$upload_path.$image_full_name;
		            $success=$image->move($upload_path,$image_full_name);
		            if ($success) {
		            	$img=DB::table('products')->where('id',$sId)->first();
		                $image_path=$img->photo;
		                $done=unlink($image_path);
		                Product::updateOrCreate(['id' => $sId],['product_name' => $request->product_name, 
													'category_id' => $request->category_id,
													'supplier_id' => $request->supplier_id,
													'product_code' => $request->product_code,
													'product_description' => $request->product_description,
													'photo' => $image_url,
													'stock' => $request->stock,
													'buying_price' => $request->buying_price,
													'selling_price' => $request->selling_price,
													'sales' => $request->sales,
													'vat' => $request->vat]);
		            }
                }
    		}
    	}

    	return redirect()->route('products.index');

	}


	public function show($id)
	{
		$singleProduct = DB::table('products')
                        ->join('categories','products.category_id','categories.id')
                        ->join('suppliers','products.supplier_id','suppliers.id')
                        ->select('categories.category_name','products.*','suppliers.name')
                        ->where('products.id',$id)
                        ->first();
		return Response::json($singleProduct);
		
	}




	public function edit($id)
	{
		$where = array('id' => $id);
		$product = Product::where($where)->first();
		return Response::json($product);
	}


	public function destroy($id)
	{
		$deleteProduct = DB::table('products')
                        ->where('id',$id)
                        ->first();
        $photoPath=$deleteProduct->photo;
        unlink($photoPath);

        $product = Product::where('id',$id)->delete();
		return Response::json($product);
	}


	public function barcode(Request $request)
	{
		$productID=$request->id;
		$ProductName=$request->barcode_name;
		$amount=$request->barcode_amount;
		$producto = DB::table('products')
                        ->where('id',$productID)
                        ->first();

         $code=$producto->product_code; 

         $data = DNS1D::getBarcodeSVG($producto->product_code, 'C128',1,50); 
         // $item=$producto->product_name;             
		// echo "<pre>";
		// print_r($productID);
		// echo "<br>";
		// print_r($ProductName);
		// echo "<br>";
		// print_r($amount);
		// echo "<br>";
		// exit();

		return view('barcode',compact('amount','ProductName','productID','code','data'));
	}


	public function OrderProducts()
	{

		$lowStock = DB::table('products')->where('stock','<=',10)->get();

		return view('order_products',compact('lowStock'));
	}


}
