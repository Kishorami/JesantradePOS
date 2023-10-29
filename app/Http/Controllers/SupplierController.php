<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Supplier;
// use Datatables;
use DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Redirect,Response;



class SupplierController extends Controller
{
    
	    /**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index(Request $request)
	{
		if ($request->ajax()) {
		$data = Supplier::latest()->get();
		return Datatables::of($data)
		->addIndexColumn()
		->addColumn('action', function($row){

		$action = '<a class="btn btn-warning btn-sm" id="edit-supplier" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i></a>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<a id="delete-supplier" data-id='.$row->id.' class="btn btn-danger delete-supplier btn-sm"><i class="fas fa-trash"></i></a>';

		return $action;

		})
		->rawColumns(['action'])
		->make(true);
		}

		return view('supplier');
	}

	public function store(Request $request)
	{

		$r=$request->validate([
		'name' => 'required',
		'phone' => 'required',

		]);


		// echo "<pri>";
		// echo "store";
		// print_r($request->id);
		// exit();

		$sId = $request->id;
		Supplier::updateOrCreate(['id' => $sId],['name' => $request->name, 'phone' => $request->phone]);
		if(empty($request->id))
		$msg = 'Supplier created successfully.';
		else
		$msg = 'Supplier data is updated successfully';
		return redirect()->route('suppliers.index')->with('success',$msg);
	}



	public function show($id)
	{
		$where = array('id' => $id);
		$supplier = Supplier::where($where)->first();
		return Response::json($supplier);
		//return view('users.show',compact('user'));
	}

	public function edit($id)
	{
		$where = array('id' => $id);

		 // 	echo "<pri>";
		 // 	echo "edit";
			// print_r($where);
			// exit();

		$supplier = Supplier::where($where)->first();
		return Response::json($supplier);
	}

	public function destroy($id)
	{
		$supplier = Supplier::where('id',$id)->delete();
		return Response::json($supplier);
		//return redirect()->route('users.index');
	}


}
