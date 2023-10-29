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
if(document.expensesForm.expenses.value !='' && document.expensesForm.expenses_amount.value !='' )
document.expensesForm.btnsave.disabled=false
else
document.expensesForm.btnsave.disabled=true
}
</script>






<div class="content-page">
<!-- Start content -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Expenses</h1>
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
        <h3 class="card-title">Expenses</h3>
        <a style="color:white" class="btn btn-success float-right mb-2" id="new-expenses" data-toggle="modal">New Expenses</a>               
      </div>
      <div class="card-body">
        <div class="container">
          

            <table class="table table-bordered data-table-expenses" >
            <thead>
            <tr id="">
            <th width="5%">S/N</th>
            <th width="30%">Expenses</th>
            <th width="15%">Amount</th>
            <th width="30%">Time</th>
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
<div class="modal fade" id="crud-modal-expenses" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="expensesCrudModal"></h4>
      </div>
      <div class="modal-body">
        <form name="expensesForm" action="{{ route('expenses.store') }}" method="POST">
          <input type="hidden" name="id" id="expenses_id" >
          @csrf
          <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
          <strong>Expenses:</strong>
          <input type="text" name="expenses" id="expenses_expenses" class="form-control" placeholder="Expenses" onchange="validate()" >
          </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
          <strong>Amount:</strong>
          <input type="text" name="expenses_amount" id="idexpenses_amount" class="form-control" placeholder="Amount" onchange="validate()">
          </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12 text-center">
          <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>Save</button>
          <a href="{{ route('expenses.index') }}" class="btn btn-danger">Cancel</a>
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

var table = $('.data-table-expenses').DataTable({
processing: true,
serverSide: true,
ajax: "{{ route('expenses.index') }}",
columns: [
{data: 'id', name: 'id'},
{data: 'expenses', name: 'expenses'},
{data: 'expenses_amount', name: 'expenses_amount'},
{data: 'created_at', name: 'created_at'},
{data: 'action', name: 'action', orderable: false, searchable: false},
]
});

/* When click New customer button */
$('#new-expenses').click(function () {
$('#btn-save').val("create-expenses");
$('#expenses').trigger("reset");
$('#expensesCrudModal').html("Add New expenses");
$('#crud-modal-expenses').modal('show');
});

/* Edit expenses */
$('body').on('click', '#edit-expenses', function () {
var expenses_id = $(this).data('id');
$.get('expenses/'+expenses_id+'/edit', function (data) {
$('#expensesCrudModal').html("Edit expenses");
$('#btn-update').val("Update");
$('#btn-save').prop('disabled',false);
$('#crud-modal-expenses').modal('show');
$('#expenses_id').val(data.id);
$('#expenses_expenses').val(data.expenses);
$('#idexpenses_amount').val(data.expenses_amount);

})
});


/* Delete customer */
$('body').on('click', '#delete-expenses', function () {
var expenses_id = $(this).data("id");
var token = $("meta[name='csrf-token']").attr("content");
var result = confirm("Are You sure want to delete !");

if (result) {

$.ajax({
type: "DELETE",
url: "expenses/"+expenses_id,
data: {
"id": expenses_id,
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