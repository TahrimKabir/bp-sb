<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BP SB Course</title>
  <link rel="shortcut icon" href="{{asset('images/logo.png')}}" type="image/x-icon">

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
    
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row mt-2">
          <div class="col-lg-12 ">
            <!-- small box -->
            
              <div class="card">
                <div class="card-header clr-dark-green text-center">
                  <h3 class="display-6"> Welcome, {{Auth::user()->name }}!!!</h3>
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
