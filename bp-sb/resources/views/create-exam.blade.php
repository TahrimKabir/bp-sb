
{{-- start --}}
@extends('dashboard')
@section('style')
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
<!-- daterange picker -->
<link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="../../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="../../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<!-- BS Stepper -->
<link rel="stylesheet" href="../../plugins/bs-stepper/css/bs-stepper.min.css">
<!-- dropzonejs -->
<link rel="stylesheet" href="../../plugins/dropzone/min/dropzone.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="../../dist/css/adminlte.min.css">
<link rel="stylesheet" href="{{asset('custom/main.css')}}">
@endsection

@section('main')
    @parent

    <!-- Content Wrapper. Contains page content -->
@section('edit')
    
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        {{-- <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                  
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Course List</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div> --}}
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-8 justify-content-center mt-5">
                    <div class="card">
                        <div class="card-header clr-dark-green text-white">
                            <h2 class="display-6 mb-0 text-center">
                                Create Exam
                            </h2>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" >
                                <div class="row">
                                    <div class="col-12">
                                    <label for="exam" class="d-block mb-0">Exam Name
                                        <input type="text" name="exam" id="exam" class="form-control">
                                    </label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label for="course" class="d-block mb-0">Select Course
                                            <select name="course" id="course" class="select2 form-control" style="width:100%;">

                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-md-6 mt-md-0 mt-2">
                                        <label for="type" class="d-block mb-0">Select Type
                                            <select name="type" id="type" class="select2 form-control" style="width:100%;">

                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <label for="details" class="d-block mb-0">Exam Details
                                            <textarea name="details" id="details" cols="30" rows="3" class="form-control">

                                            </textarea>
                                        </label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 d-flex">
                                        <button class="btn btn-sm clr-dark-green ml-auto">
                                            create
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    </div>
                 </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@endsection
<!-- ./wrapper -->

<!-- jQuery -->
@section('script')
@parent
@endsection
