@extends('home')
@section('content')

@php

  $Sessionid=Auth::id();
  $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
  $role = $Sessionuser->role;

  // echo "<pre>";
  // print_r($role);
  // exit();

  if ($role ==3){

    echo "<pre>";
    echo '<h1>"You Shall Not Pass!!!!" &#128545;</h1>';
    exit();

  }
  
@endphp

<div class="content-page">
<!-- Start content -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Here</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
</div>

<div class="content-page">
<!-- Start content -->
<div class="content">
    <div class="container">

        
	        <div class="row">

	        <!-- Add Category Form start-->
	        <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h3 class="panel-title">Edit User Information</h3></div>
                        	@if ($errors->any())
          							    <div class="alert alert-danger">
          							        <ul>
          							            @foreach ($errors->all() as $error)
          							                <li>{{ $error }}</li>
          							            @endforeach
          							        </ul>
          							    </div>
          							@endif
                        <div class="panel-body">
                            <form class="form-horizontal" role="form"action="{{ url('/update-user/'.$editUser->id ) }}" method="post" enctype="multipart/form-data">
                            	@csrf
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label">Name</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="name" value="{{ $editUser->name }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label">Email</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="email" value="{{ $editUser->email }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label">Password</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="password" value="" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label">Phone</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="phone" value="{{ $editUser->phone }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label">User Role</label>
                                    @php
                                    $roles=DB::table('user_roles')->get();
                                    @endphp
                                    <div class="col-sm-9">
                                    	<select name="role" class="form-control">
    	                                	<option value="" readonly>Select Category</option>
                                        	@foreach($roles as $row)
                                        		<option value="{{ $row->id }}" <?php if($editUser->role==$row->id){echo "selected";}?> >{{ $row->role_name }}</option>
                                        	@endforeach
                                      	</select>
                                    </div>
                                </div>
                                <div class="form-group">
                                	{{-- <img id="image" src="#"> --}}
                                    <label for="inputPassword3" class="col-sm-3 control-label">Photo</label>
                                    <div class="col-sm-9">
                                      <input type="file" name="photo" accept="image/*" class="upload" onchange="readURL(this);">
                                    </div>
                                    <img id="image" src="{{ URL::to($editUser->photo )}}" width="80px">
                                </div>
                                
                                <div class="form-group m-b-0">
                                    <div class="col-sm-offset-3 col-sm-9">
                                      <button type="submit" class="btn btn-info waves-effect waves-light">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- panel-body -->
                    </div> <!-- panel -->
                </div> <!-- col-->
            <!-- Add Category Form End -->

	        </div> 

    	</div> <!-- container -->
               
	</div> <!-- content -->
</div>


<script type="text/javascript">
	function readURL(input){
		if(input.files && input.files[0]){
			var reader = new FileReader();
			reader.onload = function(e){
				$('#image')
					.attr('src', e.target.result)
					.width(80)
					.hight(80)
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
</script>

@endsection