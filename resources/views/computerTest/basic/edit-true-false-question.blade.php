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
                                        Edit True/False Question
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ url('/computer-test/basic/update-true-false-question/'.$question->question_id) }}" method="POST">
                                        @csrf
                                        @method('PUT')  <!-- Specify the PUT method for updating data -->

                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="hidden" name="cid" value="{{ $question->cid }}">
                                                <!-- Question content -->
                                                <label for="" class="d-block">Question
                                                    <textarea id="summernote" name="question_content" required>{{ old('question_content', $question->question_content) }}</textarea>
                                                </label>
                                            </div>

                                            <!-- Correct Answer Dropdown -->
                                            <div class="form-group col-md-6">
                                                <label for="correct_answer">Correct Answer</label>
                                                <select id="correct_answer" name="correct_answer" class="form-control" required>
                                                    <option value="" disabled>Select True or False</option>
                                                    <option value="true" {{ old('correct_answer', $question->correct_answer) == 'true' ? 'selected' : '' }}>True</option>
                                                    <option value="false" {{ old('correct_answer', $question->correct_answer) == 'false' ? 'selected' : '' }}>False</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="row">
                                            <div class="col-md-2">
                                                <button class="btn btn-success">Update</button>
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

<!-- jQuery -->
@section('script')
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>

    <script>
        $(function() {
            // Initialize Summernote for the question content
            $('#summernote').summernote();
        });
    </script>
@endsection
