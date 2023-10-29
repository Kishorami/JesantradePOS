<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Supplies;
// use Datatables;
use DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Redirect,Response;

class SuppliesController extends Controller
{
        /**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index(Request $request)
	{
		if ($request->ajax()) {
		$data = Supplies::latest()
						->join('suppliers','supplies.suppliers_id','suppliers.id')
						->select('suppliers.name','supplies.*')
						->get();

		// echo "<pre>";
  //   	print_r($data);
  //   	exit();


		return Datatables::of($data)
		->addIndexColumn()
		->editColumn('created_at', function($row) {
                    return $row->created_at;
                })
		->addColumn('action', function($row){

		$action = '<a class="btn btn-warning btn-sm" id="edit-supplies" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i></a>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<a id="delete-supplies" data-id='.$row->id.' class="btn btn-danger delete-supplies btn-sm"><i class="fas fa-trash"></i></a>';

		return $action;

		})
		->rawColumns(['action'])
		->make(true);
		}

		return view('supplies');
	}


	public function store(Request $request)
	{

		$r=$request->validate([
		'product_name' => 'required',
		'product_code' => 'required',
		'quantity' => 'required',
		'unit_cost' => 'required',
		'total_cost' => 'required',
		'suppliers_id' => 'required',

		]);


		// echo "<pri>";
		// echo "store";
		// print_r($request->id);
		// echo "/";
		// print_r($request->product_name);
		// echo "/";
		// print_r($request->product_code);
		// echo "/";
		// print_r($request->quantity);
		// echo "/";
		// print_r($request->unit_cost);
		// echo "/";
		// print_r($request->total_cost);
		// echo "/";
		// print_r($request->suppliers_id);
		// exit();

		$sId = $request->id;
		Supplies::updateOrCreate(['id' => $sId],['product_name' => $request->product_name, 
												'product_code' => $request->product_code,
												'quantity' => $request->quantity,
												'unit_cost' => $request->unit_cost,
												'total_cost' => $request->total_cost,
												'suppliers_id' => $request->suppliers_id]);
		if(empty($request->id))
		$msg = 'SuppliesController.php created successfully.';
		else
		$msg = 'Supplies data is updated successfully';
		return redirect()->route('supplies.index')->with('success',$msg);
	}


	public function edit($id)
	{
		$where = array('id' => $id);

		 // 	echo "<pri>";
		 // 	echo "edit";
			// print_r($where);
			// exit();

		$supplies = Supplies::where($where)->first();
		return Response::json($supplies);
	}

	public function destroy($id)
	{
		$supplies = Supplies::where('id',$id)->delete();
		return Response::json($supplies);
		//return redirect()->route('users.index');
	}


}
