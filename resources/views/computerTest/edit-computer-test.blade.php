@extends('dashboard')

@section('main')
    @parent

    <!-- Content Wrapper. Contains page content -->
    @section('edit')
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content p-4">
                <div class="container-fluid">
                    <div class="row ">
                        <div class="col-md-11">
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
                                        Edit Computer Test Question Set
                                    </h3>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button type="button" id="add-question" style="position: fixed; top: 65px; right: 10px; z-index: 1000;"
                                                    class="btn  clr-dark-green text-white mb-3">Add Question</button>
                                        </div>
                                    </div>
                                    <form action="{{url('/update-computer-test-question')}}" method="post">
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
                                        <div id="questions-container">
                                            <div class="form-group">
                                                <div class="row mb-3">
                                                    <div class="col-md-10">
                                                        <label for="question-set-name">Question Set Name</label>
                                                        <input type="text" value="{{$question->question_set_name}}" name="question_set_name" id="question-set-name" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg clr-dark-green text-white">Create
                                            </button>
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

    <script>
        $(document).ready(function () {
            // Counter to keep track of question indices
            let questionIndex = 0;

            function addQuestion() {
                let questionHtml = `
            <div class="question-section card p-3 shadow" data-question-index="${questionIndex}">
                <div class="row">
                    <div class="col-md-9">
                        <label>Question</label>
                        <textarea name="question_content[${questionIndex}]" class="form-control summernote" rows="2" required></textarea>
                    </div>
                    <div class="col-md-3">
                        <label>&nbsp;</label>
                        <div class="input-group">
                            <select name="question_type[${questionIndex}]" class="question-type btn btn-secondary p-2" required>
                                <option value="" disabled selected>Select Question Type</option>
                                <option value="mcq"><i class="bi bi-list-ol"></i> Multiple Choice</option>
                                <option value="short_question"><i class="bi bi-pencil-square"></i> Short Answer</option>
                                <option value="descriptive"><i class="bi bi-text-paragraph"></i> Descriptive</option>
                                <option value="true_false"><i class="bi bi-check-circle"></i> True/False</option>
                            </select>
                        </div>
                        <div>
                            <label>Total Marks</label>
                            <input type="number" name="marks[${questionIndex}]" value="1" min="1" required class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="dynamic-fields">
                    <!-- Dynamic Fields will be inserted here -->
                </div>
            </div>
        `;
                $('#questions-container').append(questionHtml);
                $('.summernote').summernote({
                    height: 110,
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

            }
            addQuestion();

            $(document).on('change', '.question-type', function () {
                let questionType = $(this).val();
                let dynamicFields = $(this).closest('.question-section').find('.dynamic-fields');
                let questionIndex=$(this).closest('.question-section').data('question-index');

                dynamicFields.empty();

                if (questionType === 'mcq') {

                    createMCQFields(dynamicFields, questionIndex);
                } else if (questionType === 'true_false') {
                    createTrueFalseField(dynamicFields, questionIndex);
                }
            });

            function createMCQFields(dynamicFields, index) {

                let mcqFields = `
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="option1_${index}">Option 1</label>
                    <input type="text" id="option1_${index}" name="option1[${index}]" class="form-control" required />
                </div>
                <div class="form-group col-md-6">
                    <label for="option2_${index}">Option 2</label>
                    <input type="text" id="option2_${index}" name="option2[${index}]" class="form-control" required />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="option3_${index}">Option 3</label>
                    <input type="text" id="option3_${index}" name="option3[${index}]" class="form-control" required />
                </div>
                <div class="form-group col-md-6">
                    <label for="option4_${index}">Option 4</label>
                    <input type="text" id="option4_${index}" name="option4[${index}]" class="form-control" required />
                </div>
                <div class="form-group col-md-6">
                    <label for="correct-answer_${index}">Correct Option</label>
                    <select id="correct-answer_${index}" name="correct_answer[${index}]" class="form-control" required>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                        <option value="4">Option 4</option>
                    </select>
                </div>
            </div>
        `;
                console.log(dynamicFields);
                dynamicFields.append(mcqFields);
            }

            function createTrueFalseField(dynamicFields, index) {
                let trueFalseField = `
            <div class="form-group col-md-6">
                <label for="true-false_${index}">Correct Answer</label>
                <select id="true-false_${index}" name="correct_answer[${index}]" class="form-control" required>
                    <option value="true">True</option>
                    <option value="false">False</option>
                </select>
            </div>
        `;
                dynamicFields.append(trueFalseField);
            }

            $('#add-question').click(function () {
                questionIndex++; // Increment question index after adding a new question
                addQuestion();
            });


        });

    </script>
@endsection
