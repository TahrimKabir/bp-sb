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
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-header clr-dark-green">
                                    <h3 class="text-center display-6 mb-0">
                                        Add New Course
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('courses.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="title">Course Title:</label>
                                            <input type="text" id="title" name="title" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status:</label>
                                            <select id="status" name="status" class="form-control" required>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Target Trainee:</label><br>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="target_trainee[]" value="ADD-DIG" id="trainee_add_dig">
                                                <label class="form-check-label" for="trainee_add_dig">Additional-DIG</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="target_trainee[]" value="SP" id="trainee_sp">
                                                <label class="form-check-label" for="trainee_sp"> Superintendent of Police (SP)</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="target_trainee[]" value="Add. SP" id="trainee_add_sp">
                                                <label class="form-check-label" for="trainee_add_sp">  Addl. Superintendent of Police (Add. SP)</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="target_trainee[]" value="ASP" id="trainee_asp">
                                                <label class="form-check-label" for="trainee_asp"> Assistant Superintendent of Police (ASP)</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="target_trainee[]" value="INSPECTOR" id="trainee_inspector">
                                                <label class="form-check-label" for="trainee_inspector">Inspector of Police (Insp.)</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="target_trainee[]" value="SI" id="trainee_si">
                                                <label class="form-check-label" for="trainee_si">SI</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="target_trainee[]" value="SERGEANT" id="trainee_sergeant">
                                                <label class="form-check-label" for="trainee_sergeant">Sergeant</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="target_trainee[]" value="ASI" id="trainee_asi">
                                                <label class="form-check-label" for="trainee_asi">ASI</label>
                                            </div>




                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="target_trainee[]" value="ATSI" id="trainee_atsi">
                                                <label class="form-check-label" for="trainee_atsi">ATSI</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="target_trainee[]" value="NAIK" id="trainee_naik">
                                                <label class="form-check-label" for="trainee_naik">Naik</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="target_trainee[]" value="CONSTABLE" id="trainee_constable">
                                                <label class="form-check-label" for="trainee_constable">Constable</label>
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

@section('script')
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
@endsection
