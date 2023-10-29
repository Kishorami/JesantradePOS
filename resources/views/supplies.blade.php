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


{{-- <link rel="stylesheet" href="{{ asset('plugins/yajra/Data Tables/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/yajra/Data Tables/jquery.dataTables.min.css') }}">
<script src="{{ asset('plugins/yajra/Data Tables/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/yajra/Data Tables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/yajra/Data Tables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/yajra/Data Tables/jquery.js') }}"></script>
<script src="{{ asset('plugins/yajra/Data Tables/jquery.validate.js') }}"></script> --}}
<script>
error=false

function validate()
{
if(document.suppliesForm.product_name.value !='' && document.suppliesForm.product_code.value !='' && document.suppliesForm.quantity.value !='' && document.suppliesForm.unit_cost.value !='' && document.suppliesForm.total_cost.value !='' && document.suppliesForm.suppliers_id.value !='')
{
	document.suppliesForm.btnsave.disabled=false
}
else{
		document.suppliesForm.btnsave.disabled=true
	}
}
</script>






<div class="content-page">
<!-- Start content -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Purchase Report</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
</div>

<!-----------------------------------------------Supplies-------------------------------------------------------------------->
<div class="row">

 <div class="col-lg-12 col-xs-12">
   <div class="card">
      <div class="card-header">
        <h3 class="card-title">Purchase list</h3>
        <a style="color:white" class="btn btn-success float-right mb-2" id="new-supplies" data-toggle="modal">New Purchase</a>               
      </div>
      <div class="card-body">
        <div class="container">
          

            <table class="table table-bordered data-table-supplies" >
            <thead>
            <tr id="">
	            <th>S/N</th>
	            <th>Product Name</th>
	            <th>Code</th>
	            <th>Quantity</th>
	            <th>Unit Cost</th>
	            <th>Total cost</th>
	            <th>Supplier</th>
              <th>Date (y-m-d)</th>
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
<div class="modal fade" id="crud-modal-supplies" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="suppliesCrudModal"></h4>
      </div>
      <div class="modal-body">
        <form name="suppliesForm" action="{{ route('supplies.store') }}" method="POST">
          <input type="hidden" name="id" id="supplies_id" >
          @csrf
          <div class="row">


          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
          <strong>Product Name:</strong>
          <input type="text" name="product_name" id="supplies_pname" class="form-control" placeholder="Product Name" onchange="validate()" >
          </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
          <strong>Product Code:</strong>
          <input type="text" name="product_code" id="supplies_pcode" class="form-control" placeholder="Product Code" onchange="validate()" >
          </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
          <strong>Quantity:</strong>
          <input type="text" name="quantity" id="supplies_pquantity" class="form-control" placeholder="Quantity" onchange="validate()" >
          </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
          <strong>Unit Cost:</strong>
          <input type="text" name="unit_cost" id="supplies_pucost" class="form-control" placeholder="Unit Cost" onchange="validate()" >
          </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
          <strong>Total Cost:</strong>
          <input type="text" name="total_cost" id="supplies_tcost" class="form-control" placeholder="Total Cost" onchange="validate()">
          </div>
          </div>

	        <div class="col-xs-12 col-sm-12 col-md-12">
	            <label for="inputPassword3" class="col-sm-3 control-label">Supplier</label>
	            @php
	            $supplier=DB::table('suppliers')->get();
	            @endphp
	            <div class="form-group">
	                <select id="supplies_sid" name="suppliers_id" class="form-control" onchange="validate()">
	                    <option value="" readonly>Select Supplier</option>
	                	@foreach($supplier as $row)
	                	<option value="{{ $row->id }}">{{ $row->name }}</option>
	                	@endforeach
	                </select>
	            </div>
	        </div>

          <div class="col-xs-12 col-sm-12 col-md-12 text-center">
          <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>Save</button>
          <a href="{{ route('supplies.index') }}" class="btn btn-danger">Cancel</a>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>





<!-------------------------------------------------Supplies------------------------------------------------------------------>

<!-------------------------------------------------Supplies------------------------------------------------------------------>
 {{-- <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
   <div class="card">
      <div class="card-header">
        <h3 class="card-title">Supplies</h3>
        <a style="color:white" class="btn btn-success float-right mb-2" id="new-user" data-toggle="modal">New Supply</a>               
      </div>
      <div class="card-body">



      </div>
    </div>
 </div>
 --}}


</div><!-- /.row -->
<!-------------------------------------------------Supplies------------------------------------------------------------------>







<!-------------------------------------------------Supplies Scripts------------------------------------------------------------------>
<script type="text/javascript">

$(document).ready(function () {

var table = $('.data-table-supplies').DataTable({
processing: true,
serverSide: true,
ajax: "{{ route('supplies.index') }}",
columns: [
{data: 'id', name: 'id'},
{data: 'product_name', name: 'product_name'},
{data: 'product_code', name: 'product_code'},
{data: 'quantity', name: 'quantity'},
{data: 'unit_cost', name: 'unit_cost'},
{data: 'total_cost', name: 'total_cost'},
{data: 'name', name: 'name'},
{data: 'created_at', name: 'created_at'},
{data: 'action', name: 'action', orderable: false, searchable: false},
]
});

/* When click New supplies button */
$('#new-supplies').click(function () {
$('#btn-save').val("create-supplies");
$('#supplies').trigger("reset");
$('#suppliesCrudModal').html("Add New Supplies");
$('#crud-modal-supplies').modal('show');
});

/* Edit supplies */
$('body').on('click', '#edit-supplies', function () {
var supplies_id = $(this).data('id');
$.get('supplies/'+supplies_id+'/edit', function (data) {
$('#suppliesCrudModal').html("Edit supplies");
$('#btn-update').val("Update");
$('#btn-save').prop('disabled',false);
$('#crud-modal-supplies').modal('show');
$('#supplies_id').val(data.id);
$('#supplies_pname').val(data.product_name);
$('#supplies_pcode').val(data.product_code);
$('#supplies_pquantity').val(data.quantity);
$('#supplies_pucost').val(data.unit_cost);
$('#supplies_tcost').val(data.total_cost);
$('#supplies_sid').val(data.suppliers_id);

})
});


/* Delete customer */
$('body').on('click', '#delete-supplies', function () {
var supplies_id = $(this).data("id");
var token = $("meta[name='csrf-token']").attr("content");
var result = confirm("Are You sure want to delete !");

console.log(result);
if (result) {

$.ajax({
type: "DELETE",
url: "supplies/"+supplies_id,
data: {
"id": supplies_id,
"_token": token,
},
success: function (data) {

//$('#msg').html('Customer entry deleted successfully');
//$("#customer_id_" + user_id).remove();
table.ajax.reload();
},
error: function (data) {
console.log('Error:', data);
}
});
}

});

});

</script>
<!-------------------------------------------------Supplies Scripts------------------------------------------------------------------>
@endsection