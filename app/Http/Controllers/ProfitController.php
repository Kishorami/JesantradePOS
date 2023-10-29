<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class ProfitController extends Controller
{
    
	public function View($id)
	{

		$profit_single = DB::table('profits')->where('p_bill_code',$id)->first();
		$sale_data = array();
		$sale_data = json_decode( $profit_single->p_data);

		$all_sale_data = array();
		foreach ($sale_data as $key) {

			$data = json_decode($key);
			$product = DB::table('products')->where('id',$data->id)->first();

			$data->pro_name = $product->product_name;
			$data->pro_photo = $product->photo;

			array_push($all_sale_data, $data);
		}

		// echo "<pre>";
		// print_r($all_sale_data);
		// exit();

		return view('profits',compact('profit_single','all_sale_data'));

	}

}
