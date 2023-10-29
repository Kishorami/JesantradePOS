
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



<!-----------------------------------------------POS-------------------------------------------------------------------->
<div class="col-lg-12 col-xs-12">
	<div class="card">
      <div class="card-body">
        <div class="container">
          
{{-- <form id="printForm" method="post" action="{{ route('show.invoice') }}" target="_blank">
    @csrf --}}
        
        
                <div class="price_card text-center">
                    
                    {{-- <div class="row">
                    <div class="col-md-9">
                    <select class="form-control" name="customer_id">
                        <option disabled="" selected=""> Select Customer </option>
                        @foreach($customer as $cus)
                            <option value="{{ $cus->id }}">{{ $cus->customer_name }}</option>
                        @endforeach
                    </select>  
                    </div> 
                    <div class="col-md-3">
                        <a href="#" class="btn btn-sm btn-primary pull-right waves-effect wave-light" data-toggle="modal" data-target="#addCustomer" style="margin-top: 5px;">Add New</a>
                    </div>       
                </div> --}}
                {{-- <ul class="price-features"> --}}
                    <table class="table" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>    
                        </thead>
                        @php
                        $listproduct = Cart::content()
                        @endphp
                        <tbody>
                            @foreach($listproduct as $pro)
                            <tr>
                                <th>{{ $pro->name }}</th>
                                <th>
                                    <form  action="{{ url('/cart-update/'.$pro->rowId) }}" method="post">
                                      @csrf
                                      <input type="hidden" name="idProduct" value="{{ $pro->id }}">
                                      <input type="number" name="qty" value="{{ $pro->qty }}" style="width: 80px">
                                      <button type="submit" class="btn btn-sm btn-success" style="margin-top: -2px;"><i class="fas fa-check"></i></button>
                                    </form>
                                </th>
                                <th>{{ $pro->price*$pro->qty }}</th>
                                <th><a href="{{ url('/cart-remove/'.$pro->rowId) }}"><i class="fas fa-trash"></i></a></th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                {{-- </ul> --}}

                <form  method="post" action="{{ route('hold.invoice') }}">
                   @csrf
                   <div class="row">
                    <div class="col-md-9">
                      <input type="text" list="customer" class="form-control input-sm" name="customer_id" placeholder="Customer"  required>
                      <datalist id="customer">
                        @foreach($customer as $cus)
                          <option>{{ $cus->id }} : {{ $cus->customer_name }} : {{ $cus->customer_phone }}</option>
                        @endforeach
                      </datalist>  
                    </div> 
                    <div class="col-md-3">
                        <a href="#" class="btn btn-md btn-primary pull-right waves-effect wave-light" data-toggle="modal" data-target="#addCustomer" >Add New</a>
                    </div>       
                </div><br>

                <div class="form-group row">
                      
                  <div class="col-xs-6" style="padding-left: 15px">

                    <div class="input-group">
                         {{-- <input type="hidden" name="payment_method" id="listPaymentMethod" required> --}}
                      <select class="form-control" name="payment_method" id="newPaymentMethod" required>
                        
                          <option value="" disabled>Select payment method</option>
                          <option value="cash">Cash</option>
                          <option value="bKash">bKash</option>
                          {{-- <option value="CC">Credit Card</option>
                          <option value="DC">Debit Card</option> --}}

                      </select>

                    </div>

                  </div>

                  <div class="paymentMethodBoxes"></div>

                  {{-- <input type="hidden" name="payment_method" id="listPaymentMethod" required> --}}
                  <div class="col-xs-6" style="padding-left: 15px;" style="margin-top: -4px;">
                    <input class="form-control input-sm" type="text" name="amount_paid" placeholder="Paid Amount" required>
                  </div>
                </div>


                <div class="pricing-header bg-info">
                    
                    <div class="row">
                        <div class="col-md-4"><p>Quantity: {{ Cart::count() }}</p></div>
                        <div class="col-md-4"><p>Subtotal: {{ Cart::subtotal() }}</p></div>
                        {{-- <div class="col-md-4"><p>VAT:  {{ Cart::tax() }}</p></div> --}}
                      </div>
                    <hr>
                    <input type="hidden" name="carttotal" value="{{ Cart::total() }}">     
                    <p><h4 class="text-white">Grand Total:</h4><h3 class="text-white">{{ Cart::total() }}</h3></p>
                </div> 
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- <a href="{{ route('hold-cart') }}" class="btn btn-warning">Hold</a> --}}
                    <a href="{{ route('clear-cart') }}" class="btn btn-danger">Clear Cart</a>
                    {{-- <button  class="btn btn-danger" onclick="Cart::destroy();"> clear</button> --}}
                    <button type="submit" class="btn btn-info" formaction="" onclick="this.form.submit(); this.disabled=true;">Confirm Hold</button>   
                </div> <!-- end Pricing_card -->
    

</form>


        </div>
      </div>
    </div>
</div>








<!-----------------------------------------------POS-------------------------------------------------------------------->

@endsection