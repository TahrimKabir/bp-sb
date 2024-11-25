@extends('dashboard')


@section('main')
    @parent

    <!-- Content Wrapper. Contains page content -->
    @section('edit')
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center mt-4">
                        <div class="col-12 justify-content-center">
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
                                    <h3 class=" display-6 text-center">Edit Member</h3>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form action="{{ url('/update-member/'.$member->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="bpid" class="form-label">BPID</label>
                                                <input type="text" class="form-control" id="bpid" name="bpid"
                                                       value="{{ $member->bpid }}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                       value="{{ $member->name }}" >
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="designation" class="form-label">Designation</label>
                                                <input type="text" class="form-control" id="designation"
                                                       name="designation" value="{{ $member->designation }}" >
                                            </div>
                                            <div class="col-md-6">
                                                <label for="designation_bn" class="form-label">Designation (Bangla)</label>
                                                <input type="text" class="form-control" id="designation_bn"
                                                       name="designation_bn" value="{{ $member->designation_bn }}" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="post" class="form-label">Post</label>
                                                <select class="form-control @error('post') is-invalid @enderror" id="post" name="post" required>
                                                    <option value="">Select Post</option>
                                                    <option value="ADD-DIG" {{ $member->post == 'ADD-DIG' ? 'selected' : '' }}>Additional-DIG</option>
                                                    <option value="SP" {{ $member->post == 'SP' ? 'selected' : '' }}>Superintendent of Police (SP)</option>
                                                    <option value="Add. SP" {{ $member->post == 'Add. SP' ? 'selected' : '' }}>Addl. Superintendent of Police (Add. SP)</option>
                                                    <option value="ASP" {{ $member->post == 'ASP' ? 'selected' : '' }}>Assistant Superintendent of Police (ASP)</option>
                                                    <option value="INSPECTOR" {{ $member->post == 'INSPECTOR' ? 'selected' : '' }}>Inspector of Police (Insp.)</option>
                                                    <option value="SI" {{ $member->post == 'SI' ? 'selected' : '' }}>Sub-Inspector (SI)</option>
                                                    <option value="SERGEANT" {{ $member->post == 'SERGEANT' ? 'selected' : '' }}>SERGEANT</option>
                                                    <option value="ASI" {{ $member->post == 'ASI' ? 'selected' : '' }}>Assistant Sub-Inspector (ASI)
                                                    </option>
                                                    <option value="ATSI" {{ $member->post == 'ATSI' ? 'selected' : '' }}>ATSI</option>
                                                    <option value="NAIK" {{ $member->post == 'NAIK' ? 'selected' : '' }}>Naik</option>
                                                    <option value="CONSTABLE" {{ $member->post == 'CONSTABLE' ? 'selected' : '' }}>CONSTABLE</option>
                                                </select>
                                                @error('post')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="name_bn" class="form-label">Name (Bangla)</label>
                                                <input type="text" class="form-control" id="name_bn" name="name_bn"
                                                       value="{{ $member->name_bn }}" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="posting_area" class="form-label">Posting Area</label>
                                                <input type="text" class="form-control" id="posting_area"
                                                       name="posting_area" value="{{ $member->posting_area }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="mobile" class="form-label">Mobile</label>
                                                <input type="text" class="form-control" id="mobile" name="mobile"
                                                       value="{{ $member->mobile }}"  pattern="01[3-9][0-9]{8}"
                                                       title="Please enter a valid Bangladeshi mobile number">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="dob" class="form-label">Date of Birth</label>
                                                <input type="date" class="form-control" id="dob" name="dob"
                                                       value="{{ $member->dob }}" >
                                            </div>
                                            <div class="col-md-6">
                                                <label for="joining_date" class="form-label">Joining Date</label>
                                                <input type="date" class="form-control" id="joining_date"
                                                       name="joining_date" value="{{ $member->joining_date }}" >
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </form>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
    @endsection

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
@endsection
