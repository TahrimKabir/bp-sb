@extends('dashboard')

@section('main')
    @parent

    @section('edit')
        <div class="content-wrapper">
            <section class="content p-4">
                <div class="container-fluid">

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                          <a class="nav-item nav-link active py-2" id="nav-single-member-tab" data-toggle="tab" href="#nav-single-member" role="tab" aria-controls="nav-single-member" aria-selected="true">Add Single Member</a>
                          <a class="nav-item nav-link" id="nav-bulk-member-tab" data-toggle="tab" href="#nav-bulk-member" role="tab" aria-controls="nav-bulk-member" aria-selected="false">Add/Update Bulk Amount Member</a>
                        </div>
                      </nav>
                      <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active pt-4" id="nav-single-member" role="tabpanel" aria-labelledby="nav-single-member-tab">
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
                                                    <!-- BPID Field -->
                                                    <div class="col-md-6">
                                                        <label for="bpid" class="form-label">BPID <span class="text-danger">*</span></label>
                                                        <input 
                                                            type="text" 
                                                            class="form-control @error('bpid') is-invalid @enderror" 
                                                            id="bpid" 
                                                            name="bpid" 
                                                            value="{{ old('bpid') }}" 
                                                            required
                                                        >
                                                        @error('bpid')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- Name (Bangla) Field -->
                                                    <div class="col-md-6">
                                                        <label for="name_bn" class="form-label">Name (Bangla) <span class="text-danger">*</span></label>
                                                        <input 
                                                            type="text" 
                                                            class="form-control @error('name_bn') is-invalid @enderror" 
                                                            id="name_bn" 
                                                            name="name_bn" 
                                                            value="{{ old('name_bn') }}"
                                                            required
                                                        >
                                                        @error('name_bn')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            
                                                <div class="row mb-3">
                                                    <!-- Post Dropdown -->
                                                    <div class="col-md-6">
                                                        <label for="post" class="form-label">Post <span class="text-danger">*</span></label>
                                                        <select 
                                                            class="form-control @error('post') is-invalid @enderror" 
                                                            id="post" 
                                                            name="post" 
                                                            required
                                                        >
                                                            <option value="">Select Post</option>
                                                            <option value="ADD-DIG" {{ old('post') == 'ADD-DIG' ? 'selected' : '' }}>Additional-DIG</option>
                                                            <option value="SP" {{ old('post') == 'SP' ? 'selected' : '' }}>Superintendent of Police (SP)</option>
                                                            <option value="Add. SP" {{ old('post') == 'Add. SP' ? 'selected' : '' }}>Addl. Superintendent of Police (Add. SP)</option>
                                                            <option value="ASP" {{ old('post') == 'ASP' ? 'selected' : '' }}>Assistant Superintendent of Police (ASP)</option>
                                                            <option value="INSPECTOR" {{ old('post') == 'INSPECTOR' ? 'selected' : '' }}>Inspector of Police (Insp.)</option>
                                                            <option value="SI" {{ old('post') == 'SI' ? 'selected' : '' }}>Sub-Inspector (SI)</option>
                                                            <option value="SERGEANT" {{ old('post') == 'SERGEANT' ? 'selected' : '' }}>SERGEANT</option>
                                                            <option value="ASI" {{ old('post') == 'ASI' ? 'selected' : '' }}>ASI</option>
                                                            <option value="ATSI" {{ old('post') == 'ATSI' ? 'selected' : '' }}>ATSI</option>
                                                            <option value="NAIK" {{ old('post') == 'NAIK' ? 'selected' : '' }}>Naik</option>
                                                            <option value="CONSTABLE" {{ old('post') == 'CONSTABLE' ? 'selected' : '' }}>CONSTABLE</option>
                                                        </select>
                                                        @error('post')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- Name Field -->
                                                    <div class="col-md-6">
                                                        <label for="name" class="form-label">Name (English)</label>
                                                        <input 
                                                            type="text" 
                                                            class="form-control @error('name') is-invalid @enderror" 
                                                            id="name" 
                                                            name="name" 
                                                            value="{{ old('name') }}" 
                                                        >
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                                                            
                                                <div class="row mb-3">
                                                    <!-- Designation Field -->
                                                    <div class="col-md-6">
                                                        <label for="designation" class="form-label">Designation</label>
                                                        <input 
                                                            type="text" 
                                                            class="form-control @error('designation') is-invalid @enderror" 
                                                            id="designation" 
                                                            name="designation" 
                                                            value="{{ old('designation') }}"
                                                        >
                                                        @error('designation')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                            
                                                    <!-- Designation (Bangla) Field -->
                                                    <div class="col-md-6">
                                                        <label for="designation_bn" class="form-label">Designation (Bangla)</label>
                                                        <input 
                                                            type="text" 
                                                            class="form-control @error('designation_bn') is-invalid @enderror" 
                                                            id="designation_bn" 
                                                            name="designation_bn" 
                                                            value="{{ old('designation_bn') }}"
                                                        >
                                                        @error('designation_bn')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            
                                                <div class="row mb-3">
                                                    <!-- Posting Area Field -->
                                                    <div class="col-md-6">
                                                        <label for="posting_area" class="form-label">Posting Area</label>
                                                        <input 
                                                            type="text" 
                                                            class="form-control @error('posting_area') is-invalid @enderror" 
                                                            id="posting_area" 
                                                            name="posting_area" 
                                                            value="{{ old('posting_area') }}"
                                                        >
                                                        @error('posting_area')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                            
                                                    <!-- Mobile Field -->
                                                    <div class="col-md-6">
                                                        <label for="mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
                                                        <input 
                                                            type="text" 
                                                            class="form-control @error('mobile') is-invalid @enderror" 
                                                            id="mobile" 
                                                            name="mobile" 
                                                            value="{{ old('mobile') }}" 
                                                            pattern="01[3-9][0-9]{8}" 
                                                            title="Please enter a valid Bangladeshi mobile number"
                                                            required
                                                        >
                                                        @error('mobile')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            
                                                <div class="row mb-3">
                                                    <!-- Date of Birth Field -->
                                                    <div class="col-md-6">
                                                        <label for="dob" class="form-label">Date of Birth</label>
                                                        <input 
                                                            type="date" 
                                                            class="form-control @error('dob') is-invalid @enderror" 
                                                            id="dob" 
                                                            name="dob" 
                                                            value="{{ old('dob') }}"
                                                        >
                                                        @error('dob')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                            
                                                    <!-- Joining Date Field -->
                                                    <div class="col-md-6">
                                                        <label for="joining_date" class="form-label">Joining Date</label>
                                                        <input 
                                                            type="date" 
                                                            class="form-control @error('joining_date') is-invalid @enderror" 
                                                            id="joining_date" 
                                                            name="joining_date" 
                                                            value="{{ old('joining_date') }}"
                                                        >
                                                        @error('joining_date')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            
                                                <!-- Submit Button -->
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade pt-4" id="nav-bulk-member" role="tabpanel" aria-labelledby="nav-bulk-member-tab">
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
                                                Add Bulk Member
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ url('/store-bulk-member') }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <label for="bulk-member-file">Upload Excel file</label>
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input type="file" name="bulk_member_file" class="custom-file-input" id="bulk-member-file" accept=".xlsx, .xls" required>
                                                        <label class="custom-file-label" for="bulk-member-file">Choose file</label>
                                                    </div>
                                                </div>
                                                @error('bulk_member_file')
                                                    <div class="text-danger mb-2">{{ $message }}</div>
                                                @enderror

                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                        <div class="card-footer text-right">
                                            <a href="{{ asset('/excel-template/bulk-members-tamplate.xlsx') }}" download="bulk-members-tamplate.xlsx" class="btn btn-sm btn-success">
                                                Download Excel Template
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>


                </div>
            </section>
        </div>
    @endsection

<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {        
        function getQueryParam(param) {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        let tab = getQueryParam('tab');

        if (tab && tab == 'nav-bulk-member') {   

            let tabSelector = `.nav-link[href="#nav-bulk-member"]`;
            if ($(tabSelector).length) {
                $(tabSelector).tab('show');
            }
        }

        $(document).on('change', '#bulk-member-file', function () {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').text(fileName);
        });

        $('.nav-tabs a').on('click', function (e) {
            e.preventDefault();

            const tabName = $(this).attr('href').replace('#', '');
            console.log(tabName);
            

            const currentUrl = window.location.href.split('?')[0]
            const newUrl = `${currentUrl}?tab=${tabName}`;
            window.history.pushState(null, null, newUrl);

            $(this).tab('show');
        });
    });
</script>
@endsection
