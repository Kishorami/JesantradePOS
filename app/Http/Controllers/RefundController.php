<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class RefundController extends Controller
{
     public function index()
    {
    	$refund=DB::table('refunds')->get();
    	return view('refund', compact('refund'));
    }

    public function StoreRefund(Request $request)
    {
    	

    	$data = array();
    	$data['cust_name'] = $request->cust_name;
    	$data['bill_number'] = $request->bill_number;
    	$data['prod_name'] = $request->prod_name;
    	$data['refund_reason'] = $request->refund_reason;
    	$data['refund_amount'] = $request->refund_amount;
    	
    	// echo "<pre>";
    	// print_r($data);
    	// exit();

    	
	 	$refund=DB::table('refunds')
	 			  ->insert($data);
	 	if ($refund) {
	 		$notification=array(
	 			'message'=>'Refund added Successfully',
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

    public function DeleteRefund($id)
    {
    	 

        $dltRefund= DB::table('refunds')
                        ->where('id',$id)
                        ->delete();

        if ($dltRefund) {
                    $notification=array(
                        'message'=>'Successfully Refund data Deleted',
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


    public function ViewRefund($id)
    {
    	$editRefund = DB::table('refunds')
                        ->where('id',$id)
                        ->first();
        return view('view_refund', compact('editRefund'));
    }


     public function UpdateRefund(Request $request,$id)
    {
    	
		$data = array();
    	$data['cust_name'] = $request->cust_name;
    	$data['bill_number'] = $request->bill_number;
    	$data['prod_name'] = $request->prod_name;
    	$data['refund_reason'] = $request->refund_reason;
    	$data['refund_amount'] = $request->refund_amount;
    	

        $refund=DB::table('refunds')->where('id',$id)->update($data);
        if ($refund) {
            $notification=array(
                'message'=>'Update Refund Successful',
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
