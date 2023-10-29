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
            <h1 class="m-0 text-dark">All Users</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
</div>

<!--/table starts-->
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Users</h3>
		<a style="color:white" class="btn btn-success float-right" data-toggle="modal" data-target="#modalAddUser">New User</a>               
	</div>
  <!-- /.card-header -->
  <div class="card-body">
  	 <div class="box-body">

        <!--==========================
          =  Table for  Users    =
          ===========================-->

        <table id="datatable" class="table table-bordered table-striped dt-responsive tables" width="100%">
          
          <thead>
            
            <tr>
              
              <th class="text-center" style="width:10px">S/N</th>
              <th class="text-center">Name</th>
              <th class="text-center">Email</th>
              <th class="text-center">Phone</th>
              <th class="text-center">Image</th>
              <th class="text-center">Role</th>
              <th class="text-center">Action</th>

            </tr>

          </thead>

          <tbody>
          	@foreach($users as $row)
                <tr>
                	<td>{{ $row->id }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->phone }}</td>
                    <td><img src="{{ $row->photo }}" style="height: 40px; width: 40px"></td>
                    <td>{{ $row->role_name }}</td>
                    <td>
                      <div class="btn-group">
                      	{{-- <a href="#{{ URL::to('view-employee/'.$row->id) }}" class="btn btn-info">View</a> --}}
                      	<a href="{{ URL::to('edit-user/'.$row->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        @if(Auth::id() != $row->id)
                      	<a href="{{ URL::to('/delete-user/'.$row->id) }}" class="btn btn-danger btn-sm" id="delete">Delete</a>
                        @endif
                      </div>
                    </td>
                </tr>
            @endforeach
          </tbody>

        </table>

      </div>
  </div>
</div>
<!--/table ends-->




<!--==========================
  =  Modal window for Add Users    =
  ===========================-->

<!-- Modal -->
<div id="modalAddUser" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" action="{{ url('/add-user') }}" method="post" enctype="multipart/form-data">
      	@csrf
        <!--=====================================
            MODAL HEADER
        ======================================-->  
          <div class="modal-header" style="background: #3c8dbc; color: white">
          	<h4 class="modal-title">Registration Form</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            
          </div>
          <!--=====================================
            MODAL BODY
          ======================================-->
          <div class="modal-body">
            <div class="box-body">
            	@if ($errors->any())
				    <div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				@endif
              <!-- TAKING NAME FOR NEW USER -->
              <div class="form-group">          
                <div class="input-group">             
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>&nbsp;&nbsp;
                  <input type="text" class="form-control input-lg" name="name" placeholder="Name" required>
                </div>
              </div>
              
              <!-- TAKING USER EMAIL FOR NEW USER -->
              
              <div class="form-group">      
                <div class="input-group">                 
                  <span class="input-group-addon"><i class="fa fa-envelope"></i></span>&nbsp;&nbsp;
                  <input type="email" class="form-control input-lg" name="email" placeholder="Email" id="newemail" required>
                </div>
              </div>
              <!-- TAKING PASSWORD FOR NEW USER -->
              
              <div class="form-group">
                <div class="input-group">                 
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>&nbsp;&nbsp;
                  <input type="password" class="form-control input-lg" name="password" placeholder="Password" required>
                </div>
              </div>
              <!-- TAKING phone FOR NEW USER -->
              
              <div class="form-group">
                <div class="input-group">                 
                  <span class="input-group-addon"><i class="fa fa-phone"></i></span>&nbsp;&nbsp;
                  <input type="text" class="form-control input-lg" name="phone" placeholder="Phone NO." required>
                </div>
              </div>
              <!-- SELECTING ROLE FOR NEW USER -->             
              <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>&nbsp;&nbsp;
                    <select class="form-control input-lg" name="role">
                      <option value="" disabled selected>Select profile</option>

                      @foreach($roles as $optadd)
                      	<option value="{{ $optadd->id }}">{{ $optadd->role_name }}</option>
                      @endforeach

                    </select>
                  </div>
                </div>
                <!-- UPLOADING IMAGE -->
                <div class="form-group">
	            	{{-- <img id="image" src="#"> --}}
	                <label for="inputPassword3" class="col-sm-3 control-label">Photo</label>
	                <div class="col-sm-9">
	                  <input type="file" name="photo" accept="image/*" class="upload" required onchange="readURL(this);">
	                </div>
	                <img id="image" src="images/default/ProPic.jpg" width="80px">
	            </div>
            </div>
          </div>
          <!--=====================================
            MODAL FOOTER
          ======================================-->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary waves-effect waves-light">Create</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
    </form>
    </div>
  </div>
</div>

<!--====  End of module add user  ====-->


<!--==========================
  =  Modal window for Edit Users    =
  ===========================-->



<!--====  End of module edit user  ====-->



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
