<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Expense;
// use Datatables;
use DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Redirect,Response;

class ExpensesController extends Controller
{
    
	    /**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index(Request $request)
	{
		if ($request->ajax()) {
		$data = Expense::latest()->get();
		return Datatables::of($data)
		->addIndexColumn()
		->editColumn('created_at', function($row) {
                    return $row->created_at;
                })
		->addColumn('action', function($row){

		$action = '<a class="btn btn-warning btn-sm" id="edit-expenses" data-toggle="modal" data-id='.$row->id.'><i class="fas fa-pen-fancy"></i></a>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<a id="delete-expenses" data-id='.$row->id.' class="btn btn-danger delete-expenses btn-sm"><i class="fas fa-trash"></i></a>';

		return $action;

		})
		->rawColumns(['action'])
		->make(true);
		}

		return view('all_expenses');
	}

	public function store(Request $request)
	{

		$r=$request->validate([
		'expenses' => 'required',
		'expenses_amount' => 'required',

		]);


		// echo "<pri>";
		// echo "store";
		// print_r($request->id);
		// exit();

		$sId = $request->id;
		Expense::updateOrCreate(['id' => $sId],['expenses' => $request->expenses, 'expenses_amount' => $request->expenses_amount]);
		if(empty($request->id))
		$msg = 'Expenses created successfully.';
		else
		$msg = 'Expenses data is updated successfully';
		return redirect()->route('expenses.index')->with('success',$msg);
	}



	public function show($id)
	{
		$where = array('id' => $id);
		$expenses = Expense::where($where)->first();
		return Response::json($expenses);
		//return view('users.show',compact('user'));
	}

	public function edit($id)
	{
		$where = array('id' => $id);

		 // 	echo "<pri>";
		 // 	echo "edit";
			// print_r($where);
			// exit();

		$expenses = Expense::where($where)->first();
		return Response::json($expenses);
	}

	public function destroy($id)
	{
		$expenses = Expense::where('id',$id)->delete();
		return Response::json($expenses);
		//return redirect()->route('users.index');
	}
}
