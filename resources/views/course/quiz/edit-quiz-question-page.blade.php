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
                                Edit Question
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('quiz-question-update',$question->question_id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="course_id" class="d-block">Course</label>
                                        <select name="course_id" id="course_id" class="form-control">
                                            <option value="">Select a Course</option>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id_courses }}"
                                                    {{ $question->course_id == $course->id_courses ? 'selected' : '' }}>
                                                    {{ $course->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="lesson_id" class="d-block">Lesson</label>
                                        <select name="lesson_id" id="lesson_id" class="form-control">
                                            <option value="">Select a Lesson</option>
                                            @foreach($courses as $course)
                                                @foreach($course->lessons as $lesson)
                                                    <option value="{{ $lesson->id_lessons }}"
                                                            data-course="{{ $course->id_courses }}"
                                                        {{ $question->lesson_id == $lesson->id_lessons ? 'selected' : '' }}>
                                                        {{ $lesson->title }}
                                                    </option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>



                                    <div class="col-md-12">


                                        <label for="" class="d-block">Question
                                            <textarea id="summernote" name="question">
                                                  {{$question->question}}
                                                </textarea>
                                        </label>



                                    </div>





                                    <div class="col-md-6">
                                        <label for="option_a" class="d-block ">
                                            option A
                                            <input type="text" id="option_a" name="a" class="form-control" value="{{$question->a}}" >

                                        </label>

                                    </div>
                                    <div class="col-md-6">
                                        <label for="option_b" class="d-block "> option B
                                            <input type="text" id="option_b" name="b" class="form-control" value="{{$question->b}}">

                                        </label>

                                    </div>
                                    <div class="col-md-6">
                                        <label for="option_c" class="d-block "> option C
                                            <input type="text" id="option_c" name="c" class="form-control" value="{{$question->c}}" >

                                        </label>

                                    </div>
                                    <div class="col-md-6">
                                        <label for="option_d" class="d-block "> option D
                                            <input type="text" id="option_d" name="d" class="form-control" value="{{$question->d}}">


                                        </label>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="option3" class="d-block "> Correct Answer
                                            <select name="answer" id="" class="select2 form-control">
                                                <option value="a" @if($question->answer=='a') selected @endif>a</option>
                                                <option value="b" @if($question->answer=='b') selected @endif>b</option>
                                                <option value="c" @if($question->answer=='c') selected @endif>c</option>
                                                <option value="d" @if($question->answer=='d') selected @endif>d</option>

                                            </select>


                                        </label>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <button class="btn btn-sm clr-dark-green form-control">update</button>
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
        $(document).ready(function () {
            $('#course_id').on('change', function () {
                let selectedCourse = $(this).val();
                $('#lesson_id option').each(function () {
                    let courseId = $(this).data('course');
                    if (!selectedCourse || courseId == selectedCourse) {
                        $(this).show(); // Show lessons matching the course
                    } else {
                        $(this).hide(); // Hide other lessons
                    }
                });

                // Reset the lesson dropdown to its default state
                $('#lesson_id').val('');
            });
        });

    })
</script>
@endsection
