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
                                        Create Computer Test Question
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{url('/store-computer-test-question')}}" method="post">
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        @csrf
                                        <div class="form-group">
                                            <label >Question</label>
                                            <textarea id="summernote" name="question_content" class="form-control" rows="5"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="question-type">Question Type</label>

                                            <select id="question-type" name="question_type" class="form-control" required>
                                                <option value="">Select Question Type</option>
                                                <option value="mcq">Multiple Choice</option>
                                                <option value="short_question">Short Answer</option>
                                                <option value="descriptive">Descriptive</option>
                                                <option value="true_false">True/False</option>

                                            </select>
                                        </div>
                                        <div id="dynamic-fields">

                                        </div>
                                        <div class="form-group">
                                            <label >Total Marks</label>
                                            <input type="number" name="marks" class="form-control" />
                                        </div>


                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg clr-dark-green text-white">Create</button>
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
    <

   </script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['forecolor', 'backcolor']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['picture']],
                    ['headings', ['style', 'paragraph', 'heading']],

                ]
            });

            $('#question-type').change(function() {
                var questionType = $(this).val();
                $('#dynamic-fields').empty();

                if (questionType === 'mcq') {
                    createMCQFields();
                }  else if (questionType === 'true_false') {
                    createTrueFalseField();
                }
            });

            function createMCQFields() {
                var mcqFields = `
                    <div class="form-group">
                        <label for="option1">Option 1</label>
                        <input type="text" id="option1" name="option1" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="option2">Option 2</label>
                        <input type="text" id="option2" name="option2" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="option3">Option 3</label>
                        <input type="text" id="option3" name="option3" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="option4">Option 4</label>
                        <input type="text" id="option4" name="option4" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="correct-answer">Correct Option</label>
                        <select id="correct-answer" name="correct_answer" class="form-control">
                            <option value="1">Option 1</option>
                            <option value="2">Option 2</option>
                            <option value="3">Option 3</option>
                            <option value="4">Option 4</option>
                        </select>
                    </div>
                `;
                $('#dynamic-fields').append(mcqFields);
            }



            function createTrueFalseField() {
                var trueFalseField = `
                    <div class="form-group">
                        <label for="true-false">Correct Answer</label>
                        <select id="true-false" name="correct_answer" class="form-control">
                            <option value="true">True</option>
                            <option value="false">False</option>
                        </select>
                    </div>
                `;
                $('#dynamic-fields').append(trueFalseField);
            }
        });
    </script>
@endsection
