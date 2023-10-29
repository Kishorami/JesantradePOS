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
if(document.productForm.product_name.value !='' && document.productForm.category_id.value !='' && document.productForm.supplier_id.value !='' && document.productForm.product_code.value !='' && document.productForm.product_description.value !='' && document.productForm.stock.value !='' && document.productForm.buying_price.value !='' && document.productForm.selling_price.value !='' && document.productForm.sales.value !='')
{
  document.productForm.btnsave.disabled=false
}
else{
    document.productForm.btnsave.disabled=true
  }
}
</script>






<div class="content-page">
<!-- Start content -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Products</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
</div>

<!-----------------------------------------------Products-------------------------------------------------------------------->
<div class="row">

 <div class="col-lg-12 col-xs-12">
   <div class="card">
      <div class="card-header">
        <h3 class="card-title">Products</h3>
        <a style="color:white" class="btn btn-success float-right mb-2" id="new-product" data-toggle="modal">New Products</a>               
      </div>
      <div class="card-body">
        <div class="container">
          

            <table class="table table-bordered data-table-product" >
            <thead>
            <tr id="">
	            <th>S/N</th>
	            <th>Product</th>
	            <th>Code</th>
	            <th>Image</th>
	            <th>Stock</th>
	            <th>Selling Price</th>
	            {{-- <th>VAT</th> --}}
              <th>Sales</th>
	            <th>Action</th>
	            </tr>
            </thead>
            <tbody>
            </tbody>
            </table>
        </div>


      </div>
    </div>
 </div>


<!-- Add and Edit customer modal -->
<div class="modal fade" id="crud-modal-product" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="productCrudModal"></h4>
      </div>
      <div class="modal-body">
        <form name="productForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" id="idproduct_id" >
          @csrf
          <div class="row">


          <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="form-group">
          <strong>Product Name:</strong>
          <input type="text" name="product_name" id="idproduct_name" class="form-control" placeholder="Product Name" onchange="validate()" >
          </div>
          </div>

          <div class="col-xs-6 col-sm-6 col-md-6">
            <strong>Category:</strong>
            @php
            $category=DB::table('categories')->get();
            @endphp
            <div class="form-group">
              <select name="category_id" id="idcategory_id" class="form-control"onchange="validate()">
                    <option value="" readonly>Select Category</option>
                @foreach($category as $row)
                <option value="{{ $row->id }}">{{ $row->category_name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="col-xs-6 col-sm-6 col-md-6">
              <label for="inputPassword3" class="col-sm-3 control-label">Supplier:</label>
              @php
              $supplier=DB::table('suppliers')->get();
              @endphp
              <div class="form-group">
                  <select  name="supplier_id" id="idsupplier_id"class="form-control" onchange="validate()">
                      <option value="" readonly>Select Supplier</option>
                    @foreach($supplier as $row)
                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                    @endforeach
                  </select>
              </div>
          </div>

          <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label">Code:</label>
          <input type="text" name="product_code" id="idproduct_code" class="form-control" placeholder="Product Code" onchange="validate()">
          </div>
          </div>


          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
          <strong>Description:</strong>
          <input type="text" name="product_description" id="idproduct_description" class="form-control" placeholder="Product Description" onchange="validate()">
          </div>
          </div>

          <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="form-group">
          <strong>Stock:</strong>
          <input type="text" name="stock" id="idstock" class="form-control" placeholder="Stock" onchange="validate()" >
          </div>
          </div>

          <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="form-group">
          <strong>Buying Price:</strong>
          <input type="text" name="buying_price" id="idbuying_price" class="form-control" placeholder="Buying Price" onchange="validate()">
          </div>
          </div>

          <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="form-group">
          <strong>Selling Price:</strong>
          <input type="text" name="selling_price" id="idselling_price" class="form-control" placeholder="Selling Price" onchange="validate()">
          </div>
          </div>

          <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="form-group">
          <strong>Sales:</strong>
          <input type="text" name="sales" id="idsales" class="form-control" placeholder="Sold amount" onchange="validate()">
          </div>
          </div>

          <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
              <strong>Photo:</strong>
              <input type="file" name="photo" id="idphoto" accept="image/*" class="upload" onchange="readURL(this);">
            </div>
            <img id="image" src="" width="80px"alt="">
          </div>

          <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="form-group">
          {{-- <strong>VAT:</strong> --}}
          <input type="hidden" name="vat" id="idvat" class="form-control" placeholder="vat%" value="0" onchange="validate()">
          </div>
          </div>

          


          <div class="col-xs-12 col-sm-12 col-md-12 text-center">
          <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>Save</button>
          <a href="{{ route('products.index') }}" class="btn btn-danger">Cancel</a>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>





<!-------------------------------------------------Products------------------------------------------------------------------>

<!-------------------------------------------Products Show---------------------------------------------------------->
 <!-- Show user modal -->
<div class="modal fade" id="crud-modal-showproduct" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="userCrudModal-showproduct"></h4>
      </div>
      <div class="modal-body">
        <div class="row">
        <div class="col-xs-2 col-sm-2 col-md-2"></div>
          <div class="col-xs-10 col-sm-10 col-md-10 ">

            <table class="table-responsive ">
              <tr height="50px"><td><strong></strong></td><td id="sphoto"><img id="imageshow" src="" width="80px"alt=""></td></tr>
              <tr height="50px"><td><strong>Name:</strong></td><td id="p_name"></td></tr>
              <tr height="50px"><td><strong>Category:</strong></td><td id="c_id"></td></tr>
              <tr height="50px"><td><strong>Supplier:</strong></td><td id="s_id"></td></tr>
              <tr height="50px"><td><strong>Code:</strong></td><td id="p_code"></td></tr>
              <tr height="50px"><td><strong>Description:</strong></td><td id="p_description"></td></tr>
              <tr height="50px"><td><strong>Stock:</strong></td><td id="sstock"></td></tr>
              <tr height="50px"><td><strong>Buying Price:</strong></td><td id="b_price"></td></tr>
              <tr height="50px"><td><strong>Selling Price:</strong></td><td id="s_price"></td></tr>
              <tr height="50px"><td><strong>Sales:</strong></td><td id="ssales"></td></tr>
              <tr height="50px"><td><strong>VAT:</strong></td><td id="svat"></td></tr>

            <tr><td></td><td style="text-align: right "><a href="{{ route('products.index') }}" class="btn btn-danger">OK</a> </td></tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!------------------------------------------Barcode print------------------------------------------------------------>
<div class="modal fade" id="crud-modal-productbarcode" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="productbarcodeCrudModal"></h4>
      </div>
      <div class="modal-body">
        <form name="productFormbarcode" action="{{  url('print-barcode') }}" method="POST" enctype="multipart/form-data" target="_blank">
          <input type="hidden" name="id" id="barcode_id" >
          @csrf
          <div class="row">

          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
          <strong>Product Name:</strong>
          <input type="text" name="barcode_name" id="barcode_name" class="form-control" placeholder="Product Name" onchange="validate()" readonly>
          </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
          <strong>Barcode Amount:</strong>
          <input type="text" name="barcode_amount" id="barcode_amount" class="form-control" placeholder="Barcode Amount" onchange="validate()" >
          </div>
          </div>

          
          <div class="col-xs-12 col-sm-12 col-md-12 text-center">
          <button type="submit" id="btn-print" name="btnprint" class="btn btn-primary" disabled>Print</button>
          <a href="{{ route('products.index') }}" class="btn btn-danger">Cancel</a>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>





<!------------------------------------------Barcode print------------------------------------------------------------>

</div><!-- /.row -->








<!-------------------------------------------------Products Scripts------------------------------------------------------------------>
<script type="text/javascript">

$(document).ready(function () {

var table = $('.data-table-product').DataTable({
processing: true,
serverSide: true,
ajax: "{{ route('products.index') }}",
columns: [
{data: 'id', name: 'id'},
{data: 'product_name', name: 'product_name'},
{data: 'product_code', name: 'product_code'},
{data: 'photo', name: 'photo', 
  render: function(data,type,row){
                   return '<img src="'+data+'",width=30px, height=30px />'},
             orderable: false
},
{data: 'stock', name: 'stock'},
// {data: 'stock', name: 'stock', orderable: false, searchable: false},
  

{data: 'selling_price', name: 'selling_price'},
// {data: 'vat', name: 'vat'},
{data: 'sales', name: 'sales'},
{data: 'action', name: 'action', orderable: false, searchable: false},
]
});

/* When click New products button */
$('#new-product').click(function () {
$('#btn-save').val("create-product");
$('#product').trigger("reset");
$('#productCrudModal').html("Add New product");
$('#crud-modal-product').modal('show');
});

/* Edit product */
$('body').on('click', '#edit-product', function () {
var product_id = $(this).data('id');
$.get('products/'+product_id+'/edit', function (data) {
$('#productCrudModal').html("Edit product");
$('#btn-update').val("Update");
$('#btn-save').prop('disabled',false);
$('#crud-modal-product').modal('show');
$('#idproduct_id').val(data.id);
$('#idproduct_name').val(data.product_name);
$('#idcategory_id').val(data.category_id);
$('#idsupplier_id').val(data.supplier_id);
$('#idproduct_code').val(data.product_code);
$('#idproduct_description').val(data.product_description);
$('#idstock').val(data.stock);
$('#idbuying_price').val(data.buying_price);
$('#idselling_price').val(data.selling_price);
$('#idsales').val(data.sales);
$('#idvat').val(data.vat);
// $('#idphoto').val(data.photo);
var json= JSON.stringify( data);
      var stringify = JSON.parse(json);
      for (var i = 0; i < stringify.length; i++) {
          console.log(stringify[i]['photo']);
      }
var imagepath = stringify['photo'];
$(".modal-body #image").attr("src", imagepath);

})
});

/* Show Product */
    $('body').on('click', '#show-product', function () {
    var product_id = $(this).data('id');
    console.log(product_id);
    $.get('products/'+product_id, function (data) {

    $('#p_name').html(data.product_name);
    $('#c_id').html(data.category_name);
    $('#s_id').html(data.name);
    $('#p_code').html(data.product_code);
    $('#p_description').html(data.product_description);
    $('#sstock').html(data.stock);
    $('#b_price').html(data.buying_price);
    $('#s_price').html(data.selling_price);
    $('#ssales').html(data.sales);
    $('#svat').html(data.vat);
    var json= JSON.stringify( data);
      var stringify = JSON.parse(json);
      for (var i = 0; i < stringify.length; i++) {
          console.log(stringify[i]['photo']);
      }
      // console.log(stringify['photo']);

      var imagepath = stringify['photo'];
      $(".modal-body #imageshow").attr("src", imagepath);
      
    // $('#semail').html(data.email);

    })
    $('#userCrudModal-showproduct').html("Product Details");
    $('#crud-modal-showproduct').modal('show');


    });

/* Print product Barcode */
$('body').on('click', '#print-product', function () {
var product_id = $(this).data('id');
$.get('products/'+product_id+'/edit', function (data) {
$('#productbarcodeCrudModal').html("Print Barcode");
$('#btn-update').val("Update");
$('#btn-print').prop('disabled',false);
$('#crud-modal-productbarcode').modal('show');
$('#barcode_id').val(data.id);
$('#barcode_name').val(data.product_name);
$('#barcode_amount').val(data.stock);


})
});

/* Delete product */
$('body').on('click', '#delete-product', function () {
var products_id = $(this).data("id");
var token = $("meta[name='csrf-token']").attr("content");
var result = confirm("Are You sure want to delete !");

console.log(result);
if (result) {

$.ajax({
type: "DELETE",
url: "products/"+products_id,
data: {
"id": products_id,
"_token": token,
},
success: function (data) {
console.log(data);
location.reload();
//$('#msg').html('Customer entry deleted successfully');
//$("#customer_id_" + user_id).remove();
// table.ajax.reload();
},
error: function (data) {
console.log('Error:', data);
}
});
}

});

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