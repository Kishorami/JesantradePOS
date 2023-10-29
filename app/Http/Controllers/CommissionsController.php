<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Commission;
// use Datatables;
use DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Redirect,Response;

class CommissionsController extends Controller
{
    	    /**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index(Request $request)
	{

		if ($request->ajax()) {
		$data = Commission::latest()->get();

		// echo "<pre>";
		// print_r($data);
		// exit();

		return Datatables::of($data)
		->addIndexColumn()
		->addColumn('action', function($row){

		$action = '<a class="btn btn-warning btn-sm" id="edit-commission" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i></a>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<a id="delete-commission" data-id='.$row->id.' class="btn btn-danger delete-commission btn-sm"><i class="fas fa-trash"></i></a>';

		return $action;

		})
		->rawColumns(['action'])
		->make(true);
		}

		return view('all_commissions');
	}

	public function store(Request $request)
	{

		$r=$request->validate([
		'name' => 'required',
		'bill_no' => 'required',
		'commission_amount' => 'required',

		]);


		// echo "<pri>";
		// echo "store";
		// print_r($request->all());
		// exit();

		$sId = $request->id;
		Commission::updateOrCreate(['id' => $sId],['persons_name' => $request->name, 'persons_contact' => $request->contact, 'bill_number' => $request->bill_no, 'commission_amount' => $request->commission_amount]);
		if(empty($request->id))
		$msg = 'Commission created successfully.';
		else
		$msg = 'Commission data is updated successfully';
		return redirect()->route('commissions.index')->with('success',$msg);
	}



	public function show($id)
	{
		$where = array('id' => $id);
		$commissions = Commission::where($where)->first();
		return Response::json($commissions);
		//return view('users.show',compact('user'));
	}

	public function edit($id)
	{
		$where = array('id' => $id);

		 // 	echo "<pri>";
		 // 	echo "edit";
			// print_r($where);
			// exit();

		$commissions = Commission::where($where)->first();
		return Response::json($commissions);
	}

	public function destroy($id)
	{
		$commissions = Commission::where('id',$id)->delete();
		return Response::json($commissions);
		//return redirect()->route('users.index');
	}


}
