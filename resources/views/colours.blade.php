@extends('home')
@section('content')

<head>
    <title>Bootstrap Color Picker Plugin Example</title>
    {{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.6/css/bootstrap-colorpicker.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-2.2.2.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.6/js/bootstrap-colorpicker.js"></script>
</head>



<div class="card card-info" style="margin-left: 25%; margin-right: 25%">
  <div class="card-header">
    <h3 class="card-title">Color & Time Picker</h3>
  </div>
  <div class="card-body">
    <!-- Color Picker -->
    <form role="form" action="{{ url('/side_colour') }}" method="post" enctype="multipart/form-data">
      	@csrf
    <div class="form-group">
      <label>Sidebar Colour</label>
      <div class="row">
      	<div class="col-sm-11">
      		<input type="text" class="form-control my-colorpicker1" id="sidebar" name="sidecolour" value="{{ $sideC }}">
      	</div>
      	<button type="submit" class="btn btn-primary waves-effect waves-light">Set</button>
  	  </div>
    </div>
    <!-- /.form group -->
	</form>
	<br>
	<form role="form" action="{{ url('/nav_colour') }}" method="post" enctype="multipart/form-data">
      	@csrf
    <div class="form-group">
      <label>Navbar Colour</label>
      <div class="row">
      	<div class="col-sm-11">
      		<input type="text" class="form-control my-colorpicker1" id="navbar" name="navcolour" value="{{ $navC }}">
      	</div>
      	<button type="submit" class="btn btn-primary waves-effect waves-light">Set</button>
  	  </div>
    </div>
    <!-- /.form group -->
	</form>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->

 <script type="text/javascript">
	$('#sidebar').colorpicker();
	$('#navbar').colorpicker();
 </script>

@endsection