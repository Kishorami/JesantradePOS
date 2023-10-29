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

<head>
    

</head>
<body>
		<div class="content-page">
		<!-- Start content -->
		<div class="content-header">
		      <div class="container-fluid">
		        <div class="row mb-2">
		          <div class="col-sm-6">
		            <h1 class="m-0 text-dark">Export Reports</h1>
		          </div><!-- /.col -->
		          
		        </div><!-- /.row -->
		      </div><!-- /.container-fluid -->
		    </div>
		</div>

        <div class="container">
	        
	        <div class="card card-primary">
	        	 <div class="card-header"><h3 class="card-title text-white">Export Products</h3></div>
	        <div class="card-body">
	            <form action="all_reports" method="POST" enctype="multipart/form-data">
	                @csrf
	                <div class="container">
		                <div class="row">
			                <label for="from" class="col-form-label">From</label>
		                    <div class="col-md-3">
			                    <input type="date" class="form-control input-sm" id="from" name="from" required>
		                    </div>
		                    <label for="from" class="col-form-label">To</label>
		                    <div class="col-md-3">
		                        <input type="date" class="form-control input-sm" id="to" name="to" required>
		                    </div>
			                    
		                    <div class="col-md-4">
		                        {{-- <button type="submit" class="btn btn-primary btn-sm" name="search" >Search</button> --}}
		                        <button type="submit" class="btn btn-success btn-md" name="exportExcel" >Download Excel</button>
		                        {{-- <button type="submit" class="btn btn-primary btn-sm">All</button> --}}
		                        <a href="{{ route('all_ProductsDownload') }}" class="pull-right btn btn-danger btn-md">All Products</a>
		                    </div>
		                </div>
		            </div>
	            </form>
	        </div>
	    </div>
	        <br>

	        
	        <div class="card card-info">
	        	<div class="card-header"><h3 class="card-title text-white">Export Sales</h3></div>
	        <div class="card-body">
	            <form action="all_SalesReport" method="POST" enctype="multipart/form-data">
	                @csrf
	                <div class="container">
		                <div class="row">
			                <label for="from" class="col-form-label">From</label>
		                    <div class="col-md-3">
			                    <input type="date" class="form-control input-sm" id="from" name="from" required>
		                    </div>
		                    <label for="from" class="col-form-label">To</label>
		                    <div class="col-md-3">
		                        <input type="date" class="form-control input-sm" id="to" name="to" required>
		                    </div>
			                    
		                    <div class="col-md-4">
		                        {{-- <button type="submit" class="btn btn-primary btn-sm" name="search" >Search</button> --}}
		                        <button type="submit" class="btn btn-info btn-md" name="exportExcel" >Download Excel</button>
		                         <a href="{{ route('all_SalesReportDownload') }}" class="pull-right btn btn-danger btn-md">All Sales</a>
		                    </div>
		                </div>
		            </div>
	            </form>
	        </div>
	    </div>
	        <br>

	        
	        <div class="card card-secondary">
	        	<div class="card-header"><h3 class="card-title text-white">Export Customers</h3></div>
	        <div class="card-body">
	            <form action="all_CustomersReport" method="POST" enctype="multipart/form-data">
	                @csrf
	                <div class="container">
		                <div class="row">
			                <label for="from" class="col-form-label">From</label>
		                    <div class="col-md-3">
			                    <input type="date" class="form-control input-sm" id="from" name="from" required>
		                    </div>
		                    <label for="from" class="col-form-label">To</label>
		                    <div class="col-md-3">
		                        <input type="date" class="form-control input-sm" id="to" name="to" required>
		                    </div>
			                    
		                    <div class="col-md-4">
		                        {{-- <button type="submit" class="btn btn-primary btn-sm" name="search" >Search</button> --}}
		                        <button type="submit" class="btn btn-secondary btn-md" name="exportExcel" >Download Excel</button>
		                         <a href="{{ route('all_CustomersReportDownload') }}" class="pull-right btn btn-danger btn-md">All Customers</a>
		                    </div>
		                </div>
		            </div>
	            </form>
	        </div>
	    </div>
	        <br>


	        <div class="card card-success">
	        	<div class="card-header"><h3 class="card-title text-white">Export Profits</h3></div>
	        <div class="card-body">
	            <form action="all_ProfitsReport" method="POST" enctype="multipart/form-data">
	                @csrf
	                <div class="container">
		                <div class="row">
			                <label for="from" class="col-form-label">From</label>
		                    <div class="col-md-3">
			                    <input type="date" class="form-control input-sm" id="from" name="from" required>
		                    </div>
		                    <label for="from" class="col-form-label">To</label>
		                    <div class="col-md-3">
		                        <input type="date" class="form-control input-sm" id="to" name="to" required>
		                    </div>
			                    
		                    <div class="col-md-4">
		                        {{-- <button type="submit" class="btn btn-primary btn-sm" name="search" >Search</button> --}}
		                        <button type="submit" class="btn btn-info btn-md" name="exportExcel" >Download Excel</button>
		                         <a href="{{ route('all_ProfitsReportDownload') }}" class="pull-right btn btn-danger btn-md">All Profits</a>
		                    </div>
		                </div>
		            </div>
	            </form>
	        </div>
	    </div>
	        <br>

		</div>
</body>

@endsection