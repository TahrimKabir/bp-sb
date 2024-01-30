<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BP SB Course</title>
@section('style')
@yield('style')
@include('layouts.style') 
@show 
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    @section('main')
<div class="wrapper">

  <!-- Preloader -->
  @include('layouts.preloader')

  <!-- Navbar -->
  @include('layouts.nav')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  @section('edit')
  @yield('edit')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-10 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner text-center">
                <h3> Welcome, {{Auth::user()->name }}!!!</h3>
                
                

                
              </div>
              
             
            </div>
          </div>
          
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  @show
  <!-- /.content-wrapper -->
  @include('layouts.footer')
</div>
@show
<!-- ./wrapper -->

<!-- jQuery -->
@section('script')
@yield('script')
@include('layouts.script')
@show
</body>
</html>
