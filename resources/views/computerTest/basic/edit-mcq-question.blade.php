@extends('dashboard')
@section('main')
    @parent

    <!-- Content Wrapper. Contains page content -->
    @section('edit')
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">
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
                                </div>
                                <div class="card-header clr-dark-green">

                                    <h3 class="text-center display-6 mb-0">
                                        Edit Question
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ url('/computer-test/basic/mcq-question-update/' . $question->question_id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <label for="" class="d-block">Question
                                            <textarea id="summernote" name="question_content">
                                                  {{$question->question_content}}
                                                </textarea>
                                        </label>
{{--                                        <div class="form-group">--}}
{{--                                            <label for="question_content">Question</label>--}}
{{--                                            <textarea class="form-control" id="question_content" name="question_content" rows="3" required>{{ $question->question_content }}</textarea>--}}
{{--                                        </div>--}}

                                        <div class="form-group">
                                            <label for="option1">Option 1</label>
                                            <input type="text" class="form-control" id="option1" name="option1" value="{{ $question->option1 }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="option2">Option 2</label>
                                            <input type="text" class="form-control" id="option2" name="option2" value="{{ $question->option2 }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="option3">Option 3</label>
                                            <input type="text" class="form-control" id="option3" name="option3" value="{{ $question->option3 }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="option4">Option 4</label>
                                            <input type="text" class="form-control" id="option4" name="option4" value="{{ $question->option4 }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="correct_answer">Correct Answer</label>
                                            <select class="form-control" id="correct_answer" name="correct_answer" required>
                                                <option value="1" @if ($question->correct_answer == 1) selected @endif>Option 1</option>
                                                <option value="2" @if ($question->correct_answer == 2) selected @endif>Option 2</option>
                                                <option value="3" @if ($question->correct_answer == 3) selected @endif>Option 3</option>
                                                <option value="4" @if ($question->correct_answer == 4) selected @endif>Option 4</option>
                                            </select>
                                        </div>

                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-primary">Update Question</button>
                                            <a href="{{ url('/computer-test/basic/mcq-question-list') }}" class="btn btn-secondary">Cancel</a>
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
    <!-- jQuery -->
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
    <!-- Summernote -->
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- CodeMirror -->
    <script src="{{asset('plugins/codemirror/codemirror.js')}}"></script>
    <script src="{{asset('plugins/codemirror/mode/css/css.js')}}"></script>
    <script src="{{asset('plugins/codemirror/mode/xml/xml.js')}}"></script>
    <script src="{{asset('plugins/codemirror/mode/htmlmixed/htmlmixed.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="../../dist/js/demo.js"></script> --}}
    <!-- Page specific script -->
    <script>
        $(function() {
            // Summernote
            $('#summernote').summernote()


        })
    </script>
@endsection
