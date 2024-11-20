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
                                        Update Lesson
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('lesson.update', $lesson->id_lessons) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <!-- Lesson Title -->
                                        <div class="form-group">
                                            <label for="title">Lesson Title</label>
                                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $lesson->title) }}" required>
                                        </div>





                                        <!-- Select Course -->
                                        <div class="form-group">
                                            <label for="courses_id">Course</label>
                                            <select class="form-control" id="courses_id" name="courses_id" required>
                                                <option value="" disabled>Select Course</option>
                                                @foreach($courses as $course)
                                                    <option value="{{ $course->id_courses }}" {{ $course->id_courses == old('courses_id', $lesson->courses_id) ? 'selected' : '' }}>
                                                        {{ $course->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg clr-dark-green text-white">Update Lesson</button>
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
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

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
