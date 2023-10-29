<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    
    public function index()
    {
    	$users=DB::table('users')
		    	->join('user_roles','users.role','user_roles.id')
		    	->select('user_roles.role_name','users.*')
		    	->get();

		$roles=DB::table('user_roles')->get();
		// echo "<pre>";
  //   	print_r($users);
  //   	exit();
    	return view('users', compact('users','roles'));
    }

    public function StoreUser(Request $request)
    {
    	$validatedData = $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|unique:users',
        'phone' => 'required',
        'password' => 'required',
    	]);

    	$data = array();
    	$data['name'] = $request->name;
    	$data['email'] = $request->email;
    	$data['password'] = Hash::make($request->password);
    	$data['phone'] = $request->phone;
    	$data['role'] = $request->role;
    	$image = $request->file('photo');

    	// echo "<pre>";
    	// print_r($data);
    	// exit();

    	if ($image){
    		$image_name=Str::random(10);
    		$ext=strtolower($image->getClientOriginalExtension());
    		$image_full_name=$image_name.'.'.$ext;
    		$upload_path='public/images/users/';
    		$image_url=$upload_path.$image_full_name;
            

    		$success=$image->move($upload_path,$image_full_name);
    		if ($success) {
    		 	$data['photo']=$image_url;
    		 	$user=DB::table('users')
    		 			  ->insert($data);
    		 	if ($user) {
    		 		$notification=array(
    		 			'message'=>'User Created Successfully',
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
    		 	return Redirect()->back();
    		 } 
    	}else{
    		return Redirect()->back();
    	}

    }


    public function EditUser($id)
    {
    	$editUser = DB::table('users')
                        ->where('id',$id)
                        ->first();
        return view('edit_user', compact('editUser'));
    }

    public function UpdateUser(Request $request,$id)
    {
    	$validatedData = $request->validate([
        'name' => 'required|max:255',
        'email' => 'required',
        'phone' => 'required',
        'password' => 'required',
    	]);

		$data = array();
    	$data['name'] = $request->name;
    	$data['email'] = $request->email;
    	$data['password'] = Hash::make($request->password);
    	$data['phone'] = $request->phone;
    	$data['role'] = $request->role;
    	$image = $request->file('photo');


        $Userinfo = DB::table('users')
                        ->where('id',$id)
                        ->first();
        // print_r($data);
        
        if(!$image){
            $data['photo']=$Userinfo->photo;

            $user=DB::table('users')->where('id',$id)->update($data);
                if ($user) {
                    $notification=array(
                        'message'=>'Update User Successful',
                        'alert-type'=>'success'
                    );
                    return Redirect()->route('users')->with($notification);

                }else{
                    $notification=array(
                        'message'=>'Something Went Wrong',
                        'alert-type'=>'error'
                    );
                    return Redirect()->back()->with($notification);
                }
        }

        if ($image){
            $image_name=Str::random(10);
            $ext=strtolower($image->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='public/images/users/';
            $image_url=$upload_path.$image_full_name;
            $success=$image->move($upload_path,$image_full_name);
            if ($success) {
                $data['photo']=$image_url;
                $img=DB::table('users')->where('id',$id)->first();
                $image_path=$img->photo;
                $done=unlink($image_path);
                $user=DB::table('users')->where('id',$id)->update($data);
                if ($user) {
                    $notification=array(
                        'message'=>'Update User Successful',
                        'alert-type'=>'success'
                    );
                    return Redirect()->route('users')->with($notification);

                }else{
                    $notification=array(
                        'message'=>'Something Went Wrong',
                        'alert-type'=>'error'
                    );
                    return Redirect()->back()->with($notification);
                }
             }else{
                return Redirect()->back();
             } 
        }else{
            return Redirect()->back();
        }
    }


    public function DeleteUser($id)
    {
    	 $deleteUser = DB::table('users')
                        ->where('id',$id)
                        ->first();


     //    echo "<pre>";
    	// print_r($deleteUser);
    	// exit();

        $photoPath=$deleteUser->photo;
        unlink($photoPath);

        $dltUser= DB::table('users')
                        ->where('id',$id)
                        ->delete();

        if ($dltUser) {
                    $notification=array(
                        'message'=>'Successfully User Deleted',
                        'alert-type'=>'success'
                    );
                    return Redirect()->route('users')->with($notification);

                }else{
                    $notification=array(
                        'message'=>'Something Went Wrong',
                        'alert-type'=>'error'
                    );
                    return Redirect()->back()->with($notification);
                }
    }



}
