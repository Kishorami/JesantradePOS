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
            <h1 class="m-0 text-dark">View Refund</h1>
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
                        <div class="panel-heading"><h3 class="panel-title">Refund Information</h3></div>
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
                            <form class="form-horizontal" role="form"action="{{ url('/update-refunds/'.$editRefund->id ) }}" method="post" enctype="multipart/form-data">
                            	@csrf
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label">Customer Name</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="cust_name" value="{{ $editRefund->cust_name }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label">Bill No.</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="bill_number" value="{{ $editRefund->bill_number }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label">Product Name</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="prod_name" value="{{ $editRefund->prod_name }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label">Reason</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="refund_reason" value="{{ $editRefund->refund_reason }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label">Refund Amount</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="refund_amount" value="{{ $editRefund->refund_amount }}" required>
                                    </div>
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


@endsection