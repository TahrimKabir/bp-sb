
{{-- start --}}
@extends('dashboard')
@section('style')
<!-- Google Font: Source Sans Pro -->
@include('layouts.selectbox')
@endsection

@section('main')
    @parent

    <!-- Content Wrapper. Contains page content -->
@section('edit')
    
    <div class="content-wrapper">
        

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-8 justify-content-center mt-5">
                    <div class="card">
                        <div class="card-header clr-dark-green text-white">
                            <h2 class="display-6 mb-0 text-center">
                               Fix Exam Schedule
                            </h2>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" >
                                <div class="row">
                                    <div class="col-12">
                                    <label for="configuration" class="d-block mb-0">Configuration Name
                                        <input type="text" name="configuration" id="configuration" class="form-control">
                                    </label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <label for="exam" class="d-block mb-0">Select Course
                                            <select name="exam_id" id="exam" class="select2 form-control" style="width:100%;">

                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label for="numques" class="d-block mb-0">Number of Questions
                                            <input type="number" name="numques" id="numques" class="form-control">
                                        </label>
                                    </div>
                                    <div class="col-md-6 mt-md-0 mt-2">
                                        <label for="pmark" class="d-block mb-0">Pass Mark
                                            <input type="number" name="pmark" id="pmark" class="form-control">
                                        </label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <label for="date" class="d-block mb-0">Exam Details
                                            <input type="date" name="date" id="date" class="form-control">
                                        </label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label for="stime" class="d-block mb-0">Start Time
                                            <input type="time" name="stime" id="stime" class="form-control">
                                        </label>
                                    </div>
                                    <div class="col-md-6 mt-md-0 mt-2">
                                        <label for="etime" class="d-block mb-0">End Time
                                            <input type="time" name="etime" id="etime" class="form-control">
                                        </label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <label for="rank" class="d-block mb-0">Rank
                                            <select name="rank" id="rank" class="select2 form-control" style="width:100%;">

                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        {{-- <div class="form-group"> --}}
                                          <label class="d-block mb-0" for="bpid">Select Police
                                          <select class="duallistbox" multiple="multiple">
                                            
                                          </select>
                                        </label>
                                        {{-- </div> --}}
                                        <!-- /.form-group -->
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
