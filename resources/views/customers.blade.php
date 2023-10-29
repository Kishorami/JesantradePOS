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

{{-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
{{-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
{{-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> --}}
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> --}}
<script>
error=false

function validate()
{
if(document.customerForm.customer_name.value !='' && document.customerForm.customer_phone.value !='' )
document.customerForm.btnsave.disabled=false
else
document.customerForm.btnsave.disabled=true
}
</script>






<div class="content-page">
<!-- Start content -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Customers</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
</div>

<!-----------------------------------------------Customers-------------------------------------------------------------------->
<div class="row">

 <div class="col-lg-12 col-xs-12">
   <div class="card col-sm-10 mx-auto">
      <div class="card-header">
        <h3 class="card-title">Customers</h3>
        <a style="color:white" class="btn btn-success float-right mb-2" id="new-customer" data-toggle="modal">New Customer</a>               
      </div>
      <div class="card-body">
        <div class="container">
          

            <table class="table table-bordered data-table-customers" >
            <thead>
            <tr id="">
            <th width="10%">S/N</th>
            <th width="40%">Name</th>
            <th width="35%">Contact</th>
            <th width="10%">Action</th>
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
<div class="modal fade" id="crud-modal-customer" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="customerCrudModal"></h4>
      </div>
      <div class="modal-body">
        <form name="customerForm" action="{{ route('customers.store') }}" method="POST">
          <input type="hidden" name="id" id="customer_id" >
          @csrf
          <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
          <strong>Name:</strong>
          <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Name" onchange="validate()" >
          </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
          <strong>Contact</strong>
          <input type="text" name="customer_phone" id="customer_phone" class="form-control" placeholder="Contact" onchange="validate()">
          </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12 text-center">
          <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>Save</button>
          <a href="{{ route('customers.index') }}" class="btn btn-danger">Cancel</a>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>





<!-------------------------------------------------customers------------------------------------------------------------------>

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







<!-------------------------------------------------customers Scripts------------------------------------------------------------------>
<script type="text/javascript">

$(document).ready(function () {

var table = $('.data-table-customers').DataTable({
processing: true,
serverSide: true,
ajax: "{{ route('customers.index') }}",
columns: [
{data: 'id', name: 'id'},
{data: 'customer_name', name: 'customer_name'},
{data: 'customer_phone', name: 'customer_phone'},
{data: 'action', name: 'action', orderable: false, searchable: false},
]
});

/* When click New customer button */
$('#new-customer').click(function () {
$('#btn-save').val("create-customer");
$('#customer').trigger("reset");
$('#customerCrudModal').html("Add New Customer");
$('#crud-modal-customer').modal('show');
});

/* Edit customer */
$('body').on('click', '#edit-customer', function () {
var customers_id = $(this).data('id');
$.get('customers/'+customers_id+'/edit', function (data) {
$('#customerCrudModal').html("Edit customer");
$('#btn-update').val("Update");
$('#btn-save').prop('disabled',false);
$('#crud-modal-customer').modal('show');
$('#customer_id').val(data.id);
$('#customer_name').val(data.customer_name);
$('#customer_phone').val(data.customer_phone);

})
});


/* Delete customer */
$('body').on('click', '#delete-customer', function () {
var customers_id = $(this).data("id");
var token = $("meta[name='csrf-token']").attr("content");
var result = confirm("Are You sure want to delete !");

if (result) {

$.ajax({
type: "DELETE",
url: "customers/"+customers_id,
data: {
"id": customers_id,
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
<!-------------------------------------------------customers Scripts------------------------------------------------------------------>
@endsection