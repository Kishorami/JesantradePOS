<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use App\Models\Category;
class CategoryController extends Controller
{
    public function index()
    {
    	$category=DB::table('categories')->get();

		// $roles=DB::table('user_roles')->get();
		// echo "<pre>";
  //   	print_r($users);
  //   	exit();
    	return view('category', compact('category'));
    }

    public function StoreCategory(Request $request)
    {
    	$validatedData = $request->validate([
        'category_name' => 'required|max:255',
    	]);

    	$data = array();
    	$data['category_name'] = $request->category_name;
    	
    	// echo "<pre>";
    	// print_r($data);
    	// exit();

    	
	 	$category=DB::table('categories')
	 			  ->insert($data);
	 	if ($category) {
	 		$notification=array(
	 			'message'=>'Category Created Successfully',
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

    public function DeleteCategory($id)
    {
    	 

        $dltCategory= DB::table('categories')
                        ->where('id',$id)
                        ->delete();

        if ($dltCategory) {
                    $notification=array(
                        'message'=>'Successfully Category Deleted',
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


    public function EditCategory($id)
    {
    	$editCategory = DB::table('categories')
                        ->where('id',$id)
                        ->first();
        return view('edit_category', compact('editCategory'));
    }


     public function UpdateCategory(Request $request,$id)
    {
    	$validatedData = $request->validate([
        'category_name' => 'required|max:255',
    	]);

		$data = array();
    	$data['category_name'] = $request->category_name;
    	

        $category=DB::table('categories')->where('id',$id)->update($data);
        if ($category) {
            $notification=array(
                'message'=>'Update Category Successful',
                'alert-type'=>'success'
            );
            return Redirect()->route('categories')->with($notification);

        }else{
            $notification=array(
                'message'=>'Something Went Wrong',
                'alert-type'=>'error'
            );
            return Redirect()->back()->with($notification);
        }
    }

       
    


}
