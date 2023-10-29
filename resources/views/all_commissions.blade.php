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
if(document.commissionForm.commission_amount.value !='' )
document.commissionForm.btnsave.disabled=false
else
document.commissionForm.btnsave.disabled=true
}
</script>






<div class="content-page">
<!-- Start content -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Commissions</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
</div>

<!-----------------------------------------------Suppliers-------------------------------------------------------------------->
<div class="row">

 <div class="col-lg-12 col-xs-12">
   <div class="card">
      <div class="card-header">
        <h3 class="card-title">Commissions</h3>
        <a style="color:white" class="btn btn-success float-right mb-2" id="new-commission" data-toggle="modal">New Commissions</a>               
      </div>
      <div class="card-body">
        <div class="container">
          

            <table class="table table-bordered data-table-commission" >
            <thead>
            <tr id="">
            <th width="5%">S/N</th>
            <th width="20%">Name</th>
            <th width="30%">Contact</th>
            <th width="10%">Bill NO</th>
            <th width="10%">Amount</th>
            <th width="15%">Action</th>
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
<div class="modal fade" id="crud-modal-commission" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="commissionCrudModal"></h4>
      </div>
      <div class="modal-body">
        <form name="commissionForm" action="{{ route('commissions.store') }}" method="POST">
          <input type="hidden" name="id" id="commission_id" >
          @csrf
          <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
          <strong>Name:</strong>
          <input type="text" name="name" id="persons_name" class="form-control" placeholder="Name" onchange="validate()" >
          </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
          <strong>Contact:</strong>
          <input type="text" name="contact" id="persons_contact" class="form-control" placeholder="Contact" onchange="validate()" >
          </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
          <strong>Bill No:</strong>
          <input type="text" name="bill_no" id="bill_no" class="form-control" placeholder="Bill No" onchange="validate()" >
          </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
          <strong>Amount:</strong>
          <input type="text" name="commission_amount" id="idcommission_amount" class="form-control" placeholder="Amount" onchange="validate()">
          </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12 text-center">
          <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>Save</button>
          <a href="{{ route('commissions.index') }}" class="btn btn-danger">Cancel</a>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>





<!-------------------------------------------------Suppliers------------------------------------------------------------------>

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







<!-------------------------------------------------Suppliers Scripts------------------------------------------------------------------>
<script type="text/javascript">

$(document).ready(function () {

var table = $('.data-table-commission').DataTable({
processing: true,
serverSide: true,
ajax: "{{ route('commissions.index') }}",
columns: [
{data: 'id', name: 'id'},
{data: 'persons_name', name: 'persons_name'},
{data: 'persons_contact', name: 'persons_contact'},
{data: 'bill_number', name: 'bill_number'},
{data: 'commission_amount', name: 'commission_amount'},
{data: 'action', name: 'action', orderable: false, searchable: false},
]
});

/* When click New customer button */
$('#new-commission').click(function () {
$('#btn-save').val("create-commission");
$('#commission').trigger("reset");
$('#commissionCrudModal').html("Add New commission");
$('#crud-modal-commission').modal('show');
});

/* Edit expenses */
$('body').on('click', '#edit-commission', function () {
var commission_id = $(this).data('id');
$.get('commissions/'+commission_id+'/edit', function (data) {
$('#commissionCrudModal').html("Edit commission");
$('#btn-update').val("Update");
$('#btn-save').prop('disabled',false);
$('#crud-modal-commission').modal('show');
$('#commission_id').val(data.id);
$('#persons_name').val(data.persons_name);
$('#persons_contact').val(data.persons_contact);
$('#bill_no').val(data.bill_number);
$('#idcommission_amount').val(data.commission_amount);

})
});


/* Delete customer */
$('body').on('click', '#delete-commission', function () {
var commission_id = $(this).data("id");
var token = $("meta[name='csrf-token']").attr("content");
var result = confirm("Are You sure want to delete !");

if (result) {

$.ajax({
type: "DELETE",
url: "commissions/"+commission_id,
data: {
"id": commission_id,
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
<!-------------------------------------------------Suppliers Scripts------------------------------------------------------------------>
@endsection