@extends('home')
@section('content')

<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
{{-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> --}}
<script>
error=false

function validate()
{
if(document.productForm.product_name.value !='' && document.productForm.category_id.value !='' && document.productForm.supplier_id.value !='' && document.productForm.product_code.value !='' && document.productForm.product_description.value !='' && document.productForm.stock.value !='' && document.productForm.buying_price.value !='' && document.productForm.selling_price.value !='' && document.productForm.sales.value !='' && document.productForm.vat.value !='')
{
	document.productForm.btnsave.disabled=false
}
else{
		document.productForm.btnsave.disabled=true
	}
}
</script>


  

    <h4>

      &nbsp;&nbsp;POS

    </h4>

 


<div class="row">
<!-----------------------------------------------POS-------------------------------------------------------------------->
<div class="col-lg-5 col-xs-12">
	<div class="card">
      <div class="card-body">
        <div class="container">
          
{{-- <form id="printForm" method="post" action="{{ route('show.invoice') }}" target="_blank">
    @csrf --}}
              <div><h5>Invoice</h5></div>
        
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
                                      <input type="hidden" name="buying_price" value="{{ $pro->buying_price }}">
                                      <input type="number" name="qty" value="{{ $pro->qty }}" style="width: 80px">
                                      <button type="submit" class="btn btn-sm btn-success" style="margin-top: -2px;"><i class="fas fa-check"></i></button>
                                    </form>
                                </th>
                                <th>
                                  <form action="{{ url('/cart-updateprice/'.$pro->rowId) }}" method="post">
                                  @csrf
                                  <input type="number" name="pri" value="{{ $pro->price*$pro->qty  }}" style="width: 80px" onchange="">
                                  <input type="hidden" name="pid" value="{{ $pro->id }}">
                                  <button type="submit" class="btn btn-sm btn-success" style="margin-top: -2px;"><i class="fas fa-check"></i></button>
                                  </form>
                              </th>
                                {{-- <th>{{ $pro->price*$pro->qty }}</th> --}}
                                <th><a href="{{ url('/cart-remove/'.$pro->rowId) }}"><i class="fas fa-trash"></i></a></th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                {{-- </ul> --}}

                <form  method="post" action="{{ route('show.invoice') }}" target="_blank">
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
                          <option value="Card">Card</option>
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
                        <div class="col-md-4"><p>Sub Total: {{ Cart::subtotal() }}</p></div>
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
                    <a href="{{ route('hold-cart') }}" class="btn btn-warning">Hold</a>
                    <a href="{{ route('clear-cart') }}" class="btn btn-danger">Clear Cart</a>
                    {{-- <button  class="btn btn-danger" onclick="Cart::destroy();"> clear</button> --}}
                    <button type="submit" class="btn btn-info" formaction="" onclick="this.form.submit(); this.disabled=true;"> Print Bill</button>   
                </div> <!-- end Pricing_card -->
    

</form>


        </div>
      </div>
    </div>
</div>








<!-----------------------------------------------POS-------------------------------------------------------------------->

<!-----------------------------------------------Products-------------------------------------------------------------------->
 <div class="col-lg-7 col-xs-12">
   <div class="card">
      <div class="card-body">
        <div class="container">
          <div><h5>Product List</h5></div>
            <form action="{{ url('cart-add-barcode') }}" id="barcodeForm" method="post">
              @csrf
               <div class="row">       
              <input type="text" name="barcode_input" placeholder="Barcode">
              </div><br>
            </form>
                    
            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Code</th>
                        <th>Stock</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>

         
                <tbody>
                    @foreach($product as $row)
                        <tr>
                            <form action="{{ url('cart-add') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $row->id }}">
                                <input type="hidden" name="name" value="{{ $row->product_name }}">
                                <input type="hidden" name="qty" value="1">
                                <input type="hidden" name="price" value="{{ $row->selling_price }}">
                                <input type="hidden" name="weight" value="1">
                            <td><img src="{{ $row->photo }}" style="height: 40px; width: 40px"></td>
                            <td>{{ $row->product_code }}</td>
                            <td>{{ $row->stock }}</td>
                            <td>{{ $row->product_name }}</td>
                            <td>
                                
                                <button type="submit" class="btn btn-info btn-sm">Add</button>
                            </td>
                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


      </div>
    </div>
 </div>


</div><!-- /.row -->








<!-------------------------------------------------Products Scripts------------------------------------------------------------------>

<!-- Add customer Modal -->
<form action="{{ url('/insert-customer-pos') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div id="addCustomer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                  <h4 class="modal-title" >Add Customer</h4> 
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                    
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
                <div class="modal-body"> 
                    
                        
                    
                        <div class="col-md-6"> 
                            <div class="form-group"> 
                                <label for="field-4" class="control-label">Name</label> 
                                <input type="text" class="form-control" id="name" name="customer_name" required> 
                            </div> 
                        </div> 
                        
                        <div class="col-md-6"> 
                            <div class="form-group"> 
                                <label for="field-6" class="control-label">Phone</label> 
                                <input type="text" class="form-control" id="phone" name="customer_phone" required> 
                            </div> 
                        </div> 
                    
                

                <div class="modal-footer"> 
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button> 
                    <button type="submit" class="btn btn-info waves-effect waves-light">Submit</button> 
                </div> 
            </div> 
        </div>
    </div><!-- /.modal -->
</form>
<!-- Add customer Modal End-->





<script type="text/javascript">
  
  $('body').keypress(function(e){
  if (e.keyCode == 13)
  {
      $('#barcodeForm').submit();
  }
  });

  
</script>


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
<!-------------------------------------------------Supplies Scripts------------------------------------------------------------------>
@endsection