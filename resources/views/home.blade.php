<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>POS</title>
  <!-- Tell the browser to be responsive to screen width -->
  {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('public/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('public/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('public/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('public/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('public/plugins/summernote/summernote-bs4.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"> --}}
  {{-- <link rel="stylesheet" href="{{ asset('public/plugins/yajra/Data Tables/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/plugins/yajra/Data Tables/jquery.dataTables.min.css') }}"> --}}

  



  <!-- Toaster -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
</head>
<body class="hold-transition sidebar-collapse sidebar-mini">
<div class="wrapper">

  @php
    $coloursinfo = DB::table('colours')
                        ->where('id',1)
                        ->first();
    $navC = $coloursinfo->nav_code;
    $sideC = $coloursinfo->colour_code;
  @endphp

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: {{ $navC }}">{{-- default background colour: #f4f6f9 --}}
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('dashboard')}}" class="nav-link">Home</a>
      </li>
      {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> --}}
    </ul>

      
    <!-- SEARCH FORM -->
    {{-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> --}}

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      
      <!-- Notifications Dropdown Menu -->

      <!-- User Dropdown Menu -->

      @php

        $Sessionid=Auth::id();
        $Sessionuser=DB::table('users')->where('id',$Sessionid)->first();

      @endphp


      <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <img class="img-circle" alt="kishorami" src="{{ asset($Sessionuser->photo) }}" width="50" style="opacity: .8">
        <span class="hidden-xs">{{ $Sessionuser->name }}</span> </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            <img class="img-circle" alt="kishorami" src="{{ asset($Sessionuser->photo) }}">
            <p>{{ $Sessionuser->name }}</p>
          </li>
          <!-- Menu Body -->
                          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-right"> <a href="{{ route('logout') }}"  onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign Out</a> </div>
          </li>
        </ul>
      </li>

      <!-- User Dropdown Menu -->

      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> --}}
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: {{ $sideC }}">{{-- default background colour: #343a40 --}}
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link">
      <img src="{{ asset('public/images/default/ProPicMin.jpg') }}"  class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">POS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset($Sessionuser->photo) }}" class="img-circle elevation-2">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ $Sessionuser->name }}</a>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          {{-- <li class="nav-item has-treeview menu-open">
            <a href="{{route('dashboard')}}" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
            <ul class="nav nav-treeview">
              
            </ul>
          </li> --}}
          @if($Sessionuser->role == 1)
            <li class="nav-item">
              <a href="{{route('dashboard')}}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
          @endif

          <li class="nav-item">
            <a href="{{route('pos-page')}}" class="nav-link active" target="_blank">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                POS
              </p>
            </a>
          </li>

          
          @if($Sessionuser->role == 1)
            <li class="nav-item">
              <a href="{{route('users')}}" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Users
                </p>
              </a>
            </li>
          @endif

          @if($Sessionuser->role == 1)
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-archive"></i>
                <p>
                  Inventory
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="{{ route('all_suppliers') }}" class="nav-link">
                    <i class="nav-icon fas fa-truck"></i>
                    <p>
                      Suppliers
                    </p>
                  </a>
                </li>
                {{-- <li class="nav-item">
                  <a href="{{ route('all_supplies') }}" class="nav-link">
                    <i class="nav-icon fas fa-list-ul"></i>
                    <p>
                      Supplies
                    </p>
                  </a>
                </li> --}}
                <li class="nav-item">
                  <a href="{{route('categories')}}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                      Categories
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('all_products')}}" class="nav-link">
                    <i class="nav-icon fa fa-shopping-basket"></i>
                    <p>
                      Products
                    </p>
                  </a>
                </li>
                @php
                  $lowStock = DB::table('products')->where('stock','<=',10)->get();

                  $stockCount = count($lowStock);
                @endphp
                <li class="nav-item">
                  <a href="{{route('order_products')}}" class="nav-link">
                    <i class="nav-icon fa fa-shopping-basket"></i>
                    <p>
                      Products to Order
                      <span class="badge badge-danger right">{{ $stockCount }}</span>
                    </p>
                  </a>
                </li>
              </ul>
            </li>
            
            <li class="nav-item">
              <a href="{{route('all_customers')}}" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Customers
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('all_supplies') }}" class="nav-link">
                <i class="nav-icon fas fa-list-ul"></i>
                <p>
                  Purchase Report
                </p>
              </a>
            </li>

          @endif

          <li class="nav-item">
            <a href="{{route('sales')}}" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Sales
              </p>
            </a>
          </li>

          
          <li class="nav-item">
            <a href="{{route('hold')}}" class="nav-link">
              <i class="nav-icon fas fa-hand-paper"></i>
              <p>
                Hold Orders 
              </p>
            </a>
          </li>

          @if($Sessionuser->role == 1)
          <li class="nav-item">
            <a href="{{route('dues')}}" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Dues
              </p>
            </a>
          </li>
          @endif

          <li class="nav-item">
            <a href="{{route('all_commissions')}}" class="nav-link">
              <i class="nav-icon ion-cash"></i>
              <p>
                Commissions
              </p>
            </a>
          </li>

          {{-- <li class="nav-item">
            <a href="{{route('all_changed_parts')}}" class="nav-link">
              <i class="nav-icon fas fa-tools"></i>
              <p>
                Changed Parts
              </p>
            </a>
          </li> --}}
          
          @if($Sessionuser->role == 1)
          <li class="nav-item">
            <a href="{{route('all_expenses')}}" class="nav-link">
              <i class="nav-icon fas fa-coins"></i>
              <p>
                Expenses
              </p>
            </a>
          </li>

          {{-- <li class="nav-item">
            <a href="{{route('taxes')}}" class="nav-link">
              <i class="nav-icon ion ion-ios-gear"></i>
              <p>
                Settings
              </p>
            </a>
          </li> --}}

          <li class="nav-item">
            <a href="{{route('all_reports')}}" class="nav-link">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>
                Reports
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('refunds')}}" class="nav-link">
              <i class="nav-icon fa fa-arrow-right"></i>
              <p>
                Refunds
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{route('quotation-page')}}" class="nav-link">
              <i class="nav-icon fas fa-list-ul"></i>
              <p>
                Quotation
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('colours')}}" class="nav-link">
              <i class="nav-icon fas fa-list-ul"></i>
              <p>
                Colours
              </p>
            </a>
          </li>

          {{-- <li class="nav-item">
            <a href="{{ route('our_backup_database') }}" class="nav-link">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Backup Database
              </p>
            </a>
          </li> --}}
          {{-- <li class="nav-item">
            <a href="http://localhost/demo/autologin?id={{ Auth::id() }}&api_token=token" class="nav-link" target="_blank">
              <i class="nav-icon fa fa-arrow-up"></i>
              <p>
                Shop 01
              </p>
            </a>
          </li> --}}
          @endif

          <li class="nav-item">
            <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" class="nav-link"><i class="nav-icon fa fa-arrow-left"></i> 
            <p>
              Logout
            </p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
            </form>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div>
        </div>
      </div>
    </div> -->
    <!-- /.content-header -->

    <!-- Main content -->
      <main class="py-1">
            @yield('content')
      </main>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<!-- jQuery -->
<script src="{{ asset('public/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('public/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('public/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('public/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('public/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('public/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('public/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('public/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('public/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('public/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{ asset('public/dist/js/pages/dashboard.js') }}"></script> --}}
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('public/dist/js/demo.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('public/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> --}}

{{-- <script src="{{ asset('public/plugins/yajra/Data Tables/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/plugins/yajra/Data Tables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/plugins/yajra/Data Tables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/plugins/yajra/Data Tables/jquery.js') }}"></script>
<script src="{{ asset('public/plugins/yajra/Data Tables/jquery.validate.js') }}"></script> --}}




<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').dataTable();
    } );
</script>
<!-- SweetAlert -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Toaster -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

<script>
            @if(Session::has('message'))
                var type = "{{ Session::get('alert-type', 'info') }}";
                switch(type){
                    case 'info':
                        toastr.info("{{ Session::get('message') }}");
                        break;

                    case 'warning':
                        toastr.warning("{{ Session::get('message') }}");
                        break;

                    case 'success':
                        toastr.success("{{ Session::get('message') }}");
                        break;

                    case 'error':
                        toastr.error("{{ Session::get('message') }}");
                        break;
                }
              @endif
        </script>


        <script>
            $(document).on("click", "#login", function(e){
                e.preventDefault();
                var link = $(this).attr("href");
                swal({
                  title: "Good job!",
                  text: "You are now logedin!",
                  icon: "success",
                });
            });
        </script>

        <script>
            $(document).on("click", "#delete", function(e){
                e.preventDefault();
                var link = $(this).attr("href");
                swal({
                  title: "Are you want to delete?",
                  text: "Once deleted, you will never get it again!",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
                    swal({title:"Poof! Your file has been deleted!", 
                      icon: "success",}).then(okay=>{
                      if(okay){
                            window.location.href = link;
                        }
                    });
                  } else {
                    swal("Your file is safe!");
                  }
                });
            });
            
        </script>

        <script>
            $(document).on("click", "#delete2", function(e){
                e.preventDefault();
                var link = $(this).attr("href");
                swal({
                  title: "Are You Relesing This Hold Order",
                  text: "This Record will Moved To Sales",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
                    swal({title:"Your record Moved to Sales!", 
                      icon: "success",}).then(okay=>{
                      if(okay){
                            window.location.href = link;
                        }
                    });
                  } else {
                    swal("Your file is safe!");
                  }
                });
            });
            
        </script>



</body>
</html>
