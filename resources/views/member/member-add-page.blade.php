@extends('dashboard')

@section('main')
    @parent

    @section('edit')
        <div class="content-wrapper">
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
                                                <input type="text" class="form-control @error('bpid') is-invalid @enderror" id="bpid" name="bpid" value="{{ old('bpid') }}" required>
                                                @error('bpid')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                                @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="designation" class="form-label">Designation</label>
                                                <input type="text" class="form-control @error('designation') is-invalid @enderror" id="designation" name="designation" value="{{ old('designation') }}">
                                                @error('designation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="designation_bn" class="form-label">Designation (Bangla)</label>
                                                <input type="text" class="form-control @error('designation_bn') is-invalid @enderror" id="designation_bn" name="designation_bn" value="{{ old('designation_bn') }}">
                                                @error('designation_bn')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="post" class="form-label">Post</label>
                                                <select class="form-control @error('post') is-invalid @enderror" id="post" name="post" required>
                                                    <option value="">Select Post</option>
                                                    <option value="ASI" {{ old('post') == 'ASI' ? 'selected' : '' }}>ASI</option>
                                                    <option value="ADD-DIG" {{ old('post') == 'ADD-DIG' ? 'selected' : '' }}>ADD-DIG</option>
                                                    <option value="ATSI" {{ old('post') == 'ATSI' ? 'selected' : '' }}>ATSI</option>
                                                    <option value="CONSTABLE" {{ old('post') == 'CONSTABLE' ? 'selected' : '' }}>CONSTABLE</option>
                                                    <option value="INSPECTOR" {{ old('post') == 'INSPECTOR' ? 'selected' : '' }}>INSPECTOR</option>
                                                    <option value="SI" {{ old('post') == 'SI' ? 'selected' : '' }}>SI</option>
                                                    <option value="SERGEANT" {{ old('post') == 'SERGEANT' ? 'selected' : '' }}>SERGEANT</option>
                                                </select>
                                                @error('post')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="name_bn" class="form-label">Name (Bangla)</label>
                                                <input type="text" class="form-control @error('name_bn') is-invalid @enderror" id="name_bn" name="name_bn" value="{{ old('name_bn') }}">
                                                @error('name_bn')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="posting_area" class="form-label">Posting Area</label>
                                                <input type="text" class="form-control @error('posting_area') is-invalid @enderror" id="posting_area" name="posting_area" value="{{ old('posting_area') }}">
                                                @error('posting_area')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="mobile" class="form-label">Mobile</label>
                                                <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ old('mobile') }}" pattern="01[3-9][0-9]{8}" title="Please enter a valid Bangladeshi mobile number">
                                                @error('mobile')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="dob" class="form-label">Date of Birth</label>
                                                <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" value="{{ old('dob') }}">
                                                @error('dob')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="joining_date" class="form-label">Joining Date</label>
                                                <input type="date" class="form-control @error('joining_date') is-invalid @enderror" id="joining_date" name="joining_date" value="{{ old('joining_date') }}">
                                                @error('joining_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endsection

@endsection
