<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;
// use Datatables;
use DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Redirect,Response;


class CustomerController extends Controller
{
        /**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index(Request $request)
	{
		if ($request->ajax()) {
		$data = Customer::latest()->get();
		return Datatables::of($data)
		->addIndexColumn()
		->addColumn('action', function($row){

		$action = '<a class="btn btn-warning btn-sm" id="edit-customer" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i></a>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<a id="delete-customer" data-id='.$row->id.' class="btn btn-danger delete-customer btn-sm"><i class="fas fa-trash"></i></a>';

		return $action;

		})
		->rawColumns(['action'])
		->make(true);
		}

		return view('customers');
	}

	public function store(Request $request)
	{

		$r=$request->validate([
		'customer_name' => 'required',
		'customer_phone' => 'required|unique:customers',

		]);


		// echo "<pri>";
		// echo "store";
		// print_r($request->id);
		// exit();

		$sId = $request->id;
		Customer::updateOrCreate(['id' => $sId],['customer_name' => $request->customer_name, 'customer_phone' => $request->customer_phone]);
		if(empty($request->id))
		$msg = 'Customer created successfully.';
		else
		$msg = 'Customer data is updated successfully';
		return redirect()->route('customers.index')->with('success',$msg);
	}



	public function show($id)
	{
		$where = array('id' => $id);
		$customer = Customer::where($where)->first();
		return Response::json($customer);
		//return view('users.show',compact('user'));
	}

	public function edit($id)
	{
		$where = array('id' => $id);

		 // 	echo "<pri>";
		 // 	echo "edit";
			// print_r($where);
			// exit();

		$customer = Customer::where($where)->first();
		return Response::json($customer);
	}

	public function destroy($id)
	{
		$customer = Customer::where('id',$id)->delete();
		return Response::json($customer);
		//return redirect()->route('users.index');
	}
}
