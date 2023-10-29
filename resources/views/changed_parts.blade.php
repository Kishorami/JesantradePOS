
@extends('home')
@section('content')

<!-- @php

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
 -->
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
if(document.changed_partsForm.changed_parts.value !='' && document.changed_partsForm.reference.value !='' && document.changed_partsForm.seller_name.value !='')
document.changed_partsForm.btnsave.disabled=false
else
document.changed_partsForm.btnsave.disabled=true
}
</script>






<div class="content-page">
<!-- Start content -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Changed Parts</h1>
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
        <h3 class="card-title">Changed Parts</h3>
        <a style="color:white" class="btn btn-success float-right mb-2" id="new-changed_parts" data-toggle="modal">New Changed Parts</a>               
      </div>
      <div>
        
        {{-- <form action="{{ route('our_backup_database') }}" method="get">
            <button style="submit" class="btn btn-primary">DB download</button>
        </form> --}}

      </div>
      <div class="card-body">
        <div class="container">
          

            <table class="table table-bordered data-table-changed_parts" >
            <thead>
            <tr id="">
            <th width="5%">S/N</th>
            <th width="30%">Changed Parts</th>
            <th width="15%">Reference</th>
            <th width="15%">Seller</th>
            <th width="25%">Time</th>
            <th width="20%">Action</th>
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
<div class="modal fade" id="crud-modal-changed_parts" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="changed_partsCrudModal"></h4>
      </div>
      <div class="modal-body">
        <form name="changed_partsForm" action="{{ route('changed_parts.store') }}" method="POST">
          <input type="hidden" name="id" id="changed_parts_id" >
          @csrf
          <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
          <strong>Changed Parts:</strong>
          <input type="text" name="changed_parts" id="info_changed_parts" class="form-control" placeholder="Changed Parts" onchange="validate()" >
          </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
          <strong>Reference:</strong>
          <input type="text" name="reference" id="idreference" class="form-control" placeholder="Reference" onchange="validate()">
          </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
          <strong>Seller:</strong>
          <input type="text" name="seller_name" id="idseller_name" class="form-control" placeholder="Seller" onchange="validate()">
          </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12 text-center">
          <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>Save</button>
          <a href="{{ route('changed_parts.index') }}" class="btn btn-danger">Cancel</a>
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

var table = $('.data-table-changed_parts').DataTable({
processing: true,
serverSide: true,
ajax: "{{ route('changed_parts.index') }}",
columns: [
{data: 'id', name: 'id'},
{data: 'changed_parts', name: 'changed_parts'},
{data: 'reference', name: 'reference'},
{data: 'seller_name', name: 'seller_name'},
{data: 'created_at', name: 'created_at'},
{data: 'action', name: 'action', orderable: false, searchable: false},
]
});

/* When click New customer button */
$('#new-changed_parts').click(function () {
$('#btn-save').val("create-changed_parts");
$('#changed_parts').trigger("reset");
$('#changed_partsCrudModal').html("Add New changed_parts");
$('#crud-modal-changed_parts').modal('show');
});

/* Edit expenses */
$('body').on('click', '#edit-changed_parts', function () {
var changed_parts_id = $(this).data('id');
$.get('changed_parts/'+changed_parts_id+'/edit', function (data) {
$('#changed_partsCrudModal').html("Edit changed_parts");
$('#btn-update').val("Update");
$('#btn-save').prop('disabled',false);
$('#crud-modal-changed_parts').modal('show');
$('#changed_parts_id').val(data.id);
$('#info_changed_parts').val(data.changed_parts);
$('#idreference').val(data.reference);
$('#idseller_name').val(data.seller_name);

})
});


/* Delete customer */
$('body').on('click', '#delete-changed_parts', function () {
var changed_parts_id = $(this).data("id");
var token = $("meta[name='csrf-token']").attr("content");
var result = confirm("Are You sure want to delete !");

if (result) {

$.ajax({
type: "DELETE",
url: "changed_parts/"+changed_parts_id,
data: {
"id": changed_parts_id,
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