@extends('home')
@section('content')

@php

  $Sessionid=Auth::id();
  $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
  $role = $Sessionuser->role;

  // echo "<pre>";
  // print_r($role);
  // exit();

  // if ($role ==3){

  //   echo "<pre>";
  //   echo '<h1>"You Shall Not Pass!!!!" &#128545;</h1>';
  //   exit();

  // }
  
@endphp

<div class="content-page">
<!-- Start content -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Holds</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
</div>

<!--/table starts-->
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Holds</h3>
		              
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
              <th class="text-center">Customer</th>
              <th class="text-center">Reference</th>
              <th class="text-center">Sub Total</th>
              <th class="text-center">Total</th>
              <th class="text-center">Paid</th>
              <th class="text-center">Due</th>
              <th class="text-center">Date</th>
              <th class="text-center" style="width:20px">Action</th>

            </tr>

          </thead>

          <tbody>
          	@foreach($holds as $row)
                <tr>
                	<td>{{ $row->id }}</td>
                    <td>{{ $row->customer_name }}</td>
                    <td>{{ $row->bill_code}}</td>
                    <td>{{ $row->net_price }}</td>
                    <td>{{ $row->total_price }}</td>
                    <td>{{ $row->amount_paid }}</td>
                    <td>{{ $row->amount_due }}</td>
                    <td>{{ $row->saledate }}</td>
                    <td>
                      <div class="btn-group">
                          @if ($role !=3)
                        <a href="{{ URL::to('profits/'.$row->bill_code) }}" class="btn btn-success btn-sm" target="_blank"><i class="icon ion-cash"></i></a>
                        @endif
                      	<a href="{{ URL::to('print-holds/'.$row->id) }}" class="btn btn-info btn-sm" target="_blank"><i class="fas fa-print"></i></a>
                      	@if ($role !=3)
                      	<a href="{{ URL::to('edit-holds/'.$row->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-pen-fancy"></i></a>
                      	<a href="{{ URL::to('/delete-hold/'.$row->id) }}" class="btn btn-success btn-sm" id="delete2"><i class="fas fa-check"></i></a>
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




@endsection
