@extends('dashboard')

@section('main')
    @parent

    <!-- Content Wrapper. Contains page content -->
    @section('edit')
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content p-4">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
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
                                <div class="card-header clr-dark-green">
                                    <h3 class="text-center display-6 mb-0 text-white">
                                        Add Member
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ url('/store-member') }}" method="post">
                                        @csrf
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="bpid" class="form-label">BPID</label>
                                                <input type="text" class="form-control" id="bpid" name="bpid" value="{{ old('bpid') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="designation" class="form-label">Designation</label>
                                                <input type="text" class="form-control" id="designation" name="designation" value="{{ old('designation') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="designation_bn" class="form-label">Designation (Bangla)</label>
                                                <input type="text" class="form-control" id="designation_bn" name="designation_bn" value="{{ old('designation_bn') }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="post" class="form-label">Post</label>
                                                <input type="text" class="form-control" id="post" name="post" value="{{ old('post') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="name_bn" class="form-label">Name (Bangla)</label>
                                                <input type="text" class="form-control" id="name_bn" name="name_bn" value="{{ old('name_bn') }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="posting_area" class="form-label">Posting Area</label>
                                                <input type="text" class="form-control" id="posting_area" name="posting_area" value="{{ old('posting_area') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="mobile" class="form-label">Mobile</label>
                                                <input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') }}" required pattern="01[3-9][0-9]{8}" title="Please enter a valid Bangladeshi mobile number">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="dob" class="form-label">Date of Birth</label>
                                                <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="joining_date" class="form-label">Joining Date</label>
                                                <input type="date" class="form-control" id="joining_date" name="joining_date" value="{{ old('joining_date') }}" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
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
    <!-- jQuery -->
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
    <!-- Summernote -->


@endsection
