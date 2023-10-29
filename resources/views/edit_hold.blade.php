@extends('home')
@section('content')

@php

  $Sessionid=Auth::id();
  $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();
  $role = $Sessionuser->role;

  // echo "<pre>";
  // print_r($role);
  // exit();

  
  
@endphp

<div class="content-page">
<!-- Start content -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Holds</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
</div>

<div class="container">
          
          <div class="card card-secondary col-md-8 mx-auto">
             <div class="card-header"><h3 class="card-title text-white">Edit Hold Information</h3></div>
             @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
          <div class="card-body">
             <form action="{{ url('/update-hold/'.$editHold->id ) }}" method="post" enctype="multipart/form-data">
              @csrf

              @php
                $customer = DB::table('customers')->where('id',$editHold->id_customer) ->first();
              @endphp
              <div class="row">
              <div class="col-xs-8 col-sm-8 col-md-8">
                    <label for="inputPassword3" class="col-sm-3 control-label">Name</label>
                    <div class="form-group ">
                      <input type="text" class="form-control" name="customer_name" value="{{ $customer->customer_name }}" required readonly>
                    </div>
                </div>

                <div class="col-xs-4 col-sm-4 col-md-4">
                    <label>Bill No.</label>
                    <div class="form-group">
                      <input type="text" class="form-control" name="bill_code" value="{{ $editHold->bill_code }}" required readonly>
                    </div>
                </div>
                

              <div class="col-xs-6 col-sm-6 col-md-6">
                    <label for="inputPassword3" class="col-sm-3 control-label">Total</label>
                    <div class="form-group">
                      <input type="text" class="form-control" name="total" value="{{ $editHold->total_price }}" required readonly>
                    </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6">
                    <label>Amount Due</label>
                    <div class="form-group">
                      <input type="text" class="form-control" name="due" value="{{ $editHold->amount_due }}" required readonly>
                    </div>
                </div>


                <div class="col-xs-6 col-sm-6 col-md-6">
                    <label>Amount Paid</label>
                    <div class="form-group">
                      <input type="text" class="form-control" name="amount_paid" value="{{ $editHold->amount_paid }}" required readonly>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <label>Amount Pying</label>
                    <div class="form-group">
                      <input type="text" class="form-control" name="amount_paying" required>
                    </div>
                </div>
                </div>
               
                <div class="flex items-center justify-end mt-4">
                    <div >
                      <button type="submit" class="btn btn-info waves-effect waves-light">Update</button>
                    </div>
                </div>

            </form>
          </div>
      </div>

</div>
        
    	



@endsection