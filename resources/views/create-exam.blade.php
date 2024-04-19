@extends('dashboard')

@section('style')
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
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label for="exam" class="d-block mb-0">Exam Name</label>
                                                <input type="text" name="exam" id="exam" class="form-control @error('exam') is-invalid @enderror" placeholder="Enter Exam Name" required>
                                                @error('exam')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-md-0 mt-2">
                                                <label for="type" class="d-block mb-0">Select Type</label>
                                                <select name="type" id="type" class="select2 form-control @error('type') is-invalid @enderror" style="width:100%;" required>
                                                    <option value="" >Select type</option>
                                                    <option value="mcq">MCQ</option>
                                                    <option value="typing_test">Typing Test</option>
                                                    <option value="advanced_computer_test">Advanced Computer Test</option>
                                                    <option value="basic_computer_test">Basic Computer Test</option>
                                                </select>
                                                @error('type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <label for="details" class="d-block mb-0">Exam Details</label>
                                                <textarea name="details" id="details" cols="30" rows="3" class="form-control @error('details') is-invalid @enderror" placeholder="Enter Exam Details" required></textarea>
                                                @error('details')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12 d-flex">
                                                <button class="btn btn-sm clr-dark-green text-white ml-auto">
                                                    Create
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
