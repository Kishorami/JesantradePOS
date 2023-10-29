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
            <h1 class="m-0 text-dark">Refund</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
</div>

<!--/table starts-->
<div class="card col-sm-8 mx-auto">
	<div class="card-header">
		<h3 class="card-title">Refund</h3>
		<a style="color:white" class="btn btn-success float-right" data-toggle="modal" data-target="#modalAddRefund">Make Refund</a>               
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
              
              <th class="text-center" style="width: 10px">S/N</th>
              <th class="text-center">Name</th>
              <th class="text-center">Bill No.</th>
              <th class="text-center">Product Name</th>
              <th class="text-center">Amount</th>
              <th class="text-center"style="width: 20px">Action</th>
            </tr>

          </thead>

          <tbody>
          	@foreach($refund as $row)
                <tr>
                	<td>{{ $row->id }}</td>
                    <td>{{ $row->cust_name }}</td>
                    <td>{{ $row->bill_number }}</td>
                    <td>{{ $row->prod_name }}</td>
                    <td>{{ $row->refund_amount }}</td>
                    
                    <td>
                      <div class="btn-group">
                      	<a href="{{ URL::to('view-refunds/'.$row->id) }}" class="btn btn-info btn-sm">View</a>
                      	{{-- <a href="{{ URL::to('edit-category/'.$row->id) }}" class="btn btn-warning btn-sm">Edit</a> --}}
                      	<a href="{{ URL::to('/delete-refunds/'.$row->id) }}" class="btn btn-danger btn-sm" id="delete">Delete</a>
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



<!-- Modal -->
<div id="modalAddRefund" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" action="{{ url('/add-refunds') }}" method="post" enctype="multipart/form-data">
      	@csrf
        <!--=====================================
            MODAL HEADER
        ======================================-->  
          <div class="modal-header" style="background: #3c8dbc; color: white">
          	<h4 class="modal-title">Add Refund Form</h4>
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
              <!-- TAKING NAME FOR NEW Category -->
              <div class="form-group">
              <strong>Customer Name</strong>            
                <div class="input-group">           
                  {{-- <span class="input-group-addon"><i class="fa fa-th"></i></span>&nbsp;&nbsp; --}}
                  <input type="text" class="form-control input-lg" name="cust_name" placeholder="Customer name" required>
                </div>
              </div>
              <div class="form-group">
              <strong>Bill No.</strong>          
                <div class="input-group">             
                  {{-- <span class="input-group-addon"><i class="fa fa-th"></i></span>&nbsp;&nbsp; --}}
                  <input type="text" class="form-control input-lg" name="bill_number" placeholder="Bill No." required>
                </div>
              </div>
              <div class="form-group">
              <strong>Product Name</strong>          
                <div class="input-group">             
                  {{-- <span class="input-group-addon"><i class="fa fa-th"></i></span>&nbsp;&nbsp; --}}
                  <input type="text" class="form-control input-lg" name="prod_name" placeholder="Product Name" required>
                </div>
              </div>
              <div class="form-group">
              <strong>Reason</strong>          
                <div class="input-group">             
                  {{-- <span class="input-group-addon"><i class="fa fa-th"></i></span>&nbsp;&nbsp; --}}
                  <input type="text" class="form-control input-lg" name="refund_reason" placeholder="Reason" required>
                </div>
              </div>
              <div class="form-group">  
              <strong>Refund Amount</strong>        
                <div class="input-group">             
                  {{-- <span class="input-group-addon"><i class="fa fa-th"></i></span>&nbsp;&nbsp; --}}
                  <input type="text" class="form-control input-lg" name="refund_amount" placeholder="Refund Amount" required>
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


@endsection