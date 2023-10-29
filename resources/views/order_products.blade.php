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
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Products to Order</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
</div>


 <div class="col-lg-12 col-xs-12">
   <div class="card">
      {{-- <div class="card-header">
        <h3 class="card-title">products To Order</h3>
        <a style="color:white" class="btn btn-success float-right mb-2" id="new-product" data-toggle="modal">New Products</a>               
      </div> --}}
      <div class="card-body">
        <div class="container">
          

            <table id="datatable" class="table table-bordered table-striped dt-responsive tables" width="100%">
            <thead>
            <tr id="">
	            <th>S/N</th>
	            <th>Product</th>
	            <th>Code</th>
	            <th>Image</th>
	            <th>Stock</th>
	            <th>Category</th>
	            <th>Supplier</th>
              	<th>Sales</th>
	            <th>Action</th>
	            </tr>
            </thead>
            <tbody>
            	@foreach($lowStock as $row)
            	@php
                	$supplier = DB::table('suppliers')->where('id',$row->supplier_id)->first();
                	$categorie = DB::table('categories')->where('id',$row->category_id)->first();
                @endphp
                <tr>
                	<td>{{ $row->id }}</td>
                    <td>{{ $row->product_name }}</td>
                    <td>{{ $row->product_code }}</td>
                    <td><img src="{{ $row->photo }}" style="height: 40px; width: 40px"></td>
                    <td>{{ $row->stock }}</td>
                    <td>{{ $categorie->category_name }}</td>
                    
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $row->sales }}</td>
                    <td>
                      <div class="btn-group">
                      	<a href="{{ route('all_supplies') }}" class="btn btn-info btn-sm">Add More</a>
                      </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
            </table>
        </div>


      </div>
    </div>
 </div>

@endsection