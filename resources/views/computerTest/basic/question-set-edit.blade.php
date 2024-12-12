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
                                    <h3 class="text-center display-6 mb-0 text-white">
                                        Edit Question Set
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('basic-question-set.update', $questionSet->question_set_id) }}" method="POST">
                                        @csrf
                                        @method('PUT') <!-- Use PUT for updating -->

                                        <div class="form-group">
                                            <label for="question_set_name">Question Set Name:</label>
                                            <input type="text" id="question_set_name" name="question_set_name" class="form-control" value="{{ old('question_set_name', $questionSet->question_set_name) }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="num_of_mcq">Number of MCQs (Part-A):</label>
                                            <input type="number" id="num_of_mcq" name="num_of_mcq" class="form-control" min="1" value="{{ old('num_of_mcq', $questionSet->num_of_mcq) }}" required>
                                            <span id="mcq-error" class="text-danger"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="num_of_true_false">Number of True/False Questions (Part-B):</label>
                                            <input type="number" id="num_of_true_false" name="num_of_true_false" class="form-control" min="1" value="{{ old('num_of_true_false', $questionSet->num_of_true_false) }}" required>
                                            <span id="true-false-error" class="text-danger"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="num_of_typing_test">Number of Typing Test Questions (Part-C):</label>
                                            <input type="number" id="num_of_typing_test" name="num_of_typing_test" class="form-control" min="1" value="{{ old('num_of_typing_test', $questionSet->num_of_typing_test) }}" required>
                                            <span id="typing-test-error" class="text-danger"></span>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Update Question Set</button>
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
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mcqInput = document.getElementById('num_of_mcq');
            const trueFalseInput = document.getElementById('num_of_true_false');
            const typingTestInput = document.getElementById('num_of_typing_test');

            mcqInput.addEventListener('input', function() {
                validateInput(mcqInput, {{ $totalMcqQuestions }}, 'mcq-error');
            });

            trueFalseInput.addEventListener('input', function() {
                validateInput(trueFalseInput, {{ $totalTrueFalseQuestions }}, 'true-false-error');
            });

            typingTestInput.addEventListener('input', function() {
                validateInput(typingTestInput, {{ $totalTypingTestQuestions }}, 'typing-test-error');
            });

            function validateInput(inputElement, totalQuestions, errorSpanId) {
                const inputValue = parseInt(inputElement.value);
                const errorSpan = document.getElementById(errorSpanId);

                if (inputValue > totalQuestions) {
                    errorSpan.textContent = 'Number of questions exceeds the total available questions.';
                    inputElement.value = totalQuestions; // Set input value to the total number of questions
                } else {
                    errorSpan.textContent = ''; // Clear the error message
                }
            }
        });
    </script>
@endsection
