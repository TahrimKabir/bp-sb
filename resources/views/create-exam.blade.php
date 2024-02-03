{{-- start --}}
@extends('dashboard')
@section('style')
    @include('layouts.selectbox')
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
                    <div class="col-md-8 justify-content-center mt-5">
                        <div class="card">
                            <div class="card-header clr-dark-green text-white">
                                <h2 class="display-6 mb-0 text-center">
                                    Exam
                                </h2>
                            </div>
                            <div class="card-body">
                                <div id="message-container">
                                    @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('fail'))
                                    <div class="alert alert-danger">
                                        {{ session('fail') }}
                                    </div>
                                @endif
                                </div>
                                
                                <form action="{{ route('store-exam') }}" method="post">
                                    @csrf
                                    {{-- <div class="row">
                                        <div class="col-12">
                                            <label for="name" class="d-block mb-0">Exam Name
                                                <input type="text" name="exam" id="exam" class="form-control" required>
                                            </label>
                                        </div>
                                    </div> --}}
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            {{-- <label for="course" class="d-block mb-0">Select Course
                                                <select name="course_id" id="course" class="select2 form-control"
                                                    style="width:100%;" required>
                                                    @if ($course != null)
                                                        @foreach ($course as $c)
                                                            <option value="{{ $c->course_id }}">{{ $c->course_title }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </label> --}}
                                            <label for="name" class="d-block mb-0">Exam Name
                                                <input type="text" name="exam" id="exam" class="form-control" placeholder="exam name" required>
                                            </label>
                                        </div>
                                        <div class="col-md-6 mt-md-0 mt-2">
                                            <label for="type" class="d-block mb-0">Select Type
                                                <select name="type" id="type" class="select2 form-control"
                                                    style="width:100%;" required>
                                                    <option value="types" selected disabled>select type</option>
                                                    <option value="MCQ">MCQ</option>
                                                    <option value="IQ">IQ</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label for="details" class="d-block mb-0">Exam Details
                                            <textarea name="details" id="details" cols="30" rows="3" class="form-control" >

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
