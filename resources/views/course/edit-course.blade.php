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
                                        Update Course
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ url('/update-course/' . $course->id_courses) }}" method="post">
                                        @csrf

                                        <!-- Course Title -->
                                        <div class="form-group">
                                            <label for="title">Course Title</label>
                                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $course->title) }}" required>
                                        </div>

                                        <!-- Course Status -->
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="active" {{ $course->status == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ $course->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>

                                        <!-- Target Trainee (Checkboxes) -->
                                        <div class="form-group">
                                            <label for="target_trainee">Target Trainee</label><br>
                                            @php
                                                $trainees = ['SI', 'ASI', 'SERGEANT', 'CONSTABLE', 'ASP', 'SP', 'INSPECTOR', 'NAIK'];
                                                $selected_trainees = explode(',', $course->target_trainee); // Convert string to array
                                            @endphp
                                            @foreach($trainees as $trainee)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="target_trainee[]" value="{{ $trainee }}" {{ in_array($trainee, $selected_trainees) ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ $trainee }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg clr-dark-green text-white">Update</button>
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

@section('script')
    <!-- jQuery -->
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>

    <!-- Auto-hide message -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var messageContainer = document.getElementById('message-container');
            if (messageContainer) {
                setTimeout(function() {
                    messageContainer.style.display = 'none';
                }, 4000);
            }
        });
    </script>
@endsection
