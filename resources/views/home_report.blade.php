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

  {{-- <h1 style="text-align:center">Jesan Trade International</h1>
  <h1 style="text-align:center">Plaza Low Yat</h1> --}}
    <br>

  <div class="container">
          
        <div class="card card-info">
           <div class="card-header"><h3 class="card-title text-white">Pick A Date Range</h3></div>
          <div class="card-body">
              <form action="customHome" method="POST" enctype="multipart/form-data">
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
                            <button type="submit" class="btn btn-success btn-md" name="viewReport" >View report</button>
                            {{-- <button type="submit" class="btn btn-primary btn-sm">All</button> --}}
                            {{-- <a href="{{ route('all_ProductsDownload') }}" class="pull-right btn btn-danger btn-md">All Products</a> --}}
                        </div>
                    </div>
                </div>
              </form>
          </div>
      </div>
        <br>
  </div>


  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        @if ($From == 0)
          <h1 class="m-0 text-dark">All Records</h1>
        @else
          <h1 class="m-0 text-dark">Records From Date ({{ $From }}) To ({{ $To }})</h1>
        @endif
      </div><!-- /.col -->
      
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->

  <hr style="width:80%;border-width:2;text-align:left;margin-left:0;color:gray;background-color:gray">

<div class="row">

<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-info">
    
    <div class="inner">
      
      <h3>{{ $c_name }} <?php echo  number_format(floatval($salesTotal),2); ?></h3> {{-- here --}}

      <p>Sales</p>
    
    </div>
    
    <div class="icon">
      {{-- <ion-icon name="cash-outline"></ion-icon> --}}
      <i class="ion ion-cash"></i>
    
    </div>
    
    <a href="#" class="small-box-footer">
      
      &nbsp; 
    
    </a>

  </div>

</div>
  <div class="col-lg-3 col-xs-6">

  <div class="small-box bg-primary">
    
    <div class="inner">
    
      <h3><?php echo number_format($allCategories); ?></h3> {{-- here --}}

      <p>Categories</p>
    
    </div>
    
    <div class="icon">
    
      <i class="ion ion-clipboard"></i>
    
    </div>
    
    <a href="#" class="small-box-footer">
      
      &nbsp; 
    
    </a>

  </div>

</div>

<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-yellow">
    
    <div class="inner">
    
      <h3><?php echo number_format($allCustomers); ?></h3>{{-- here --}}

      <p>Customers</p>
  
    </div>
    
    <div class="icon">
    
      <i class="ion ion-person-add"></i>
    
    </div>
    
    <a href="#" class="small-box-footer">

      &nbsp; 

    </a>

  </div>

</div>

<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-secondary">
  
    <div class="inner">
    
      <h3><?php echo number_format($allProducts); ?></h3>{{-- here --}}

      <p>products</p>
    
    </div>
    
    <div class="icon">
      
      <i class="ion ion-ios-cart"></i>
    
    </div>
    
    <a href="#" class="small-box-footer">
      
      &nbsp; 
    
    </a>

  </div>

</div>

</div> {{-- row end --}}



<div class="row">  {{-- row2 --}}
  
  <div class="col-lg-3 col-xs-6">

  <div class="small-box bg-green">
    
    <div class="inner">
    
      <h3>{{ $c_name }} <?php echo number_format($collection,2); ?></h3> {{-- here --}}

      <p>Collection</p>
    
    </div>
    
    <div class="icon">
    
      <i class="ion ion-cash"></i>
    
    </div>
    
    <a href="#" class="small-box-footer">
      
      &nbsp; 
    
    </a>

  </div>

</div>

<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-olive">
    
    <div class="inner">
    
      <h3>{{ $c_name }} <?php echo number_format($due,2); ?></h3>{{-- here --}}

      <p>Due</p>
  
    </div>
    
    <div class="icon">
    
      <i class="ion ion-cash"></i>
    
    </div>
    
    <a href="#" class="small-box-footer">

      &nbsp; 

    </a>

  </div>

</div>

<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-danger">
    
    <div class="inner">
    
      <h3>{{ $c_name }} <?php echo number_format($refundTotal,2); ?></h3>{{-- here --}}

      <p>Refund</p>
  
    </div>
    
    <div class="icon">
    
      <i class="ion ion-cash"></i>
    
    </div>
    
    <a href="#" class="small-box-footer">

      &nbsp; 

    </a>

  </div>

</div>

<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-info">
    
    <div class="inner">
      
      <h3>{{ $c_name }} <?php echo number_format(floatval($holdTotal),2); ?></h3> {{-- here --}}

      <p>Hold</p>
    
    </div>
    
    <div class="icon">
      {{-- <ion-icon name="cash-outline"></ion-icon> --}}
      <i class="ion ion-cash"></i>
    
    </div>
    
    <a href="#" class="small-box-footer">
      
      &nbsp; 
    
    </a>

  </div>



</div>



</div>{{-- row2 end --}}

<div class="row">  {{-- row3 --}}

  <div class="col-lg-3 col-xs-6">

  <div class="small-box bg-danger">
    
    <div class="inner">
    
      <h3>{{ $c_name }}  <?php echo number_format($expenseTotal,2); ?></h3>{{-- here --}}

      <p>Expense</p>
  
    </div>
    
    <div class="icon">
    
      <i class="ion ion-cash"></i>
    
    </div>
    
    <a href="#" class="small-box-footer">

      &nbsp; 

    </a>

  </div>

</div>

<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-secondary">
  
    <div class="inner">
    
      <h3>{{ $c_name }} <?php echo number_format($commissionTotal); ?></h3>{{-- here --}}

      <p>Commission</p>
    
    </div>
    
    <div class="icon">
      
      <i class="ion ion-cash"></i>
    
    </div>
    
    <a href="#" class="small-box-footer">
      
      &nbsp; 
    
    </a>

  </div>

</div>


<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-success">
  
    <div class="inner">
    
      <h3>{{ $c_name }} <?php echo number_format($profit_total); ?></h3>{{-- here --}}

      <p>Profit</p>
    
    </div>
    
    <div class="icon">
      
      <i class="ion ion-cash"></i>
    
    </div>
    
    <a href="#" class="small-box-footer">
      
      &nbsp; 
    
    </a>

  </div>

</div>

</div>{{-- row3 end --}}


</div>




@endsection