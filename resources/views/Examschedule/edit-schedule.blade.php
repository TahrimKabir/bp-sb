{{-- start --}}
@extends('dashboard')
@section('style')
    <!-- Google Font: Source Sans Pro -->
    @include('layouts.selectbox')
    <style>
        /* Optional styling for frame, container, checkbox list, search bar */
        iframe {
            border: 1px solid #ccc;
            width: 300px;
            height: 200px;
        }



        .checkbox-list li {
            margin-bottom: 5px;
        }

        .checkbox-list label {
            display: block;
        }

    </style>
@endsection

@section('main')
    @parent

    <!-- Content Wrapper. Contains page content -->
    @section('edit')
        <div class="content-wrapper">


            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-12  justify-content-center mt-5">
                            <div class="card">
                                <div class="card-header clr-dark-green text-white">
                                    <h2 class="display-6 mb-0 text-center">
                                        Update Exam Schedule
                                    </h2>
                                </div>
                                <div class="card-body">
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
                                    <form action="{{ route('update-schedule', $examConfiguration->id) }}" id="sform" method="post" onsubmit="submitForm()">
                                        @csrf
                                        @method('PUT') <!-- Laravel directive to set the method to PUT -->

                                        <div class="row">
                                            <div class="col-12">
                                                <label for="name" class="d-block mb-0">Configuration Name
                                                    <input type="text" name="name" id="configuration"
                                                           class="form-control" placeholder="Configuration name"
                                                           value="{{ old('name', $examConfiguration->name) }}" required>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <label for="exam" class="d-block mb-0">Select Exam
                                                    <select name="exam_id" id="exam" class="select2 form-control"
                                                            style="width:100%;" required onchange="checkExamType()">
                                                        <option value="" disabled>Select exam</option>
                                                        @foreach ($exam as $e)
                                                            <option value="{{ $e->exam_id }}" data-type="{{ $e->type }}"
                                                                {{ $examConfiguration->exam_id == $e->exam_id ? 'selected' : '' }}>
                                                                {{ $e->exam_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                        <div id="additionalInputFieldContainer"></div>

                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <label for="date" class="d-block mb-0">Date
                                                    <input type="date" name="date" id="date" class="form-control"
                                                           value="{{ old('date', $examConfiguration->date) }}" oninput="handleInput()" required>
                                                </label>
                                                <p class="mb-0 text-danger" id="errordate" style="display: none;">The date has passed already!</p>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label for="stime" class="d-block mb-0">Start Time
                                                    <input type="time" name="start_time" id="stime" class="form-control"
                                                           value="{{ old('start_time', $examConfiguration->start_time) }}" oninput="handleInput()" required>
                                                </label>
                                            </div>
                                            <div class="col-md-6 mt-md-0 mt-2">
                                                <label for="etime" class="d-block mb-0">End Time
                                                    <input type="time" name="end_time" id="etime" class="form-control"
                                                           value="{{ old('end_time', $examConfiguration->end_time) }}" oninput="handleInput()" required>
                                                </label>
                                                <p class="mb-0 text-danger" id="show" style="display: none;">End time cannot be less than start time</p>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-12 d-flex">
                                                <button type="submit" id="submitbutton" class="btn btn-sm clr-dark-green ml-auto">
                                                    Update
                                                </button>
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
    @parent

    <script>
        // Trigger checkExamType when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            checkExamType(); // This will ensure the right fields are shown based on the selected exam
        });
        function checkExamType() {
            removeAdditionalInputField();  // Clear any previously added fields
            let selectedExam = document.getElementById('exam');
            let selectedOption = selectedExam.options[selectedExam.selectedIndex];
            let examType = selectedOption.getAttribute('data-type');

            // Pass existing values to functions
            if (examType === 'advanced_computer_test') {
                addComputerTestInputFields({{ json_encode($examConfiguration->question_set_id) }}, {{ json_encode($examConfiguration->pass_mark) }});
            }

            if (examType === 'mcq') {
                addMcqInputFields({{ json_encode($examConfiguration->total_questions) }}, {{ json_encode($examConfiguration->pass_mark) }});
            }

            if (examType === 'basic_computer_test') {
                addBasicComputerTestInputFields({{ json_encode($examConfiguration->question_set_id) }}, {{ json_encode($examConfiguration->pass_mark) }});
            }
        }

        function addBasicComputerTestInputFields(existingQuestionSetId, existingPassMark) {
            let questionSets = @json($basicQuestionSets);
            let container = document.getElementById('additionalInputFieldContainer');

            let computerTestInputFieldHTML = `
        <div class="row mt-2">
            <div class="col-md-6">
                <label for="question-set" class="d-block mb-0">Select Question set
                    <select name="question_set_id" id="question-set" class="select2 form-control" style="width:100%;" required>
                        <option value="" selected disabled>Select Question set</option>
    `;

            questionSets.forEach(function (questionSet) {
                let selected = questionSet.question_set_id === existingQuestionSetId ? 'selected' : '';
                computerTestInputFieldHTML += `
            <option value="${questionSet.question_set_id}" ${selected}>${questionSet.question_set_name}</option>
        `;
            });

            computerTestInputFieldHTML += `
                    </select>
                </label>
            </div>
            <div class="col-md-6 mt-md-0 mt-2">
                <label for="pmark" class="d-block mb-0">Pass Mark
                    <input type="number" name="pass_mark" id="pmark" class="form-control" oninput="handleInput()"
                        placeholder="digit ie. 5" value="${existingPassMark || ''}" required>
                </label>
            </div>
        </div>
    `;
            container.innerHTML = computerTestInputFieldHTML;
        }


        function addComputerTestInputFields(existingQuestionSetId, existingPassMark) {
            let questionSets = @json($advancedQuestionSets);
            let container = document.getElementById('additionalInputFieldContainer');

            let computerTestInputFieldHTML = `
        <div class="row mt-2">
            <div class="col-md-6">
                <label for="question-set" class="d-block mb-0">Select Question set
                    <select name="question_set_id" id="question-set" class="select2 form-control" style="width:100%;" required>
                        <option value="" selected disabled>Select Question set</option>
    `;

            questionSets.forEach(function (questionSet) {
                let selected = questionSet.question_set_id === existingQuestionSetId ? 'selected' : '';
                computerTestInputFieldHTML += `
            <option value="${questionSet.question_set_id}" ${selected}>${questionSet.question_set_name}</option>
        `;
            });

            computerTestInputFieldHTML += `
                    </select>
                </label>
            </div>
            <div class="col-md-6 mt-md-0 mt-2">
                <label for="pmark" class="d-block mb-0">Pass Mark
                    <input type="number" name="pass_mark" id="pmark" class="form-control" oninput="handleInput()"
                        placeholder="digit ie. 5" value="${existingPassMark || ''}" required>
                </label>
            </div>
        </div>
    `;
            container.innerHTML = computerTestInputFieldHTML;
        }


        function addMcqInputFields(existingNumQuestions, existingPassMark) {
            let container = document.getElementById('additionalInputFieldContainer');
            let mcqInputFieldHtml = `
        <div class="row mt-2">
            <div class="col-md-6">
                <label for="numques" class="d-block mb-0">Number of Questions
                    <input type="number" name="total_questions" id="numques" class="form-control" oninput="handleInput()"
                        placeholder="digit ie. 10" value="${existingNumQuestions || ''}" required>
                </label>
            </div>
            <div class="col-md-6 mt-md-0 mt-2">
                <label for="pmark" class="d-block mb-0">Pass Mark
                    <input type="number" name="pass_mark" id="pmark" class="form-control" oninput="handleInput()"
                        placeholder="digit ie. 5" value="${existingPassMark || ''}" required>
                </label>
            </div>
        </div>
    `;
            container.innerHTML = mcqInputFieldHtml;
        }


        function removeAdditionalInputField() {
            let container = document.getElementById('additionalInputFieldContainer');

            // Clear the container
            container.innerHTML = '';
        }

    </script>

    {{-- time --}}
    <script>
        // Function to compare two time strings
        function compareTimes(time1, time2) {
            var time1Parts = time1.split(':');
            var time2Parts = time2.split(':');

            var hours1 = parseInt(time1Parts[0], 10);
            var minutes1 = parseInt(time1Parts[1], 10);

            var hours2 = parseInt(time2Parts[0], 10);
            var minutes2 = parseInt(time2Parts[1], 10);

            if (hours1 !== hours2) {
                return hours1 - hours2;
            }

            return minutes1 - minutes2;
        }
        // Function to check if a date has passed
        function isDatePassed(targetDate) {
            // Get the current date
            var currentDate = new Date();
            currentDate.setHours(0, 0, 0, 0); // Set time to midnight

            // Convert the target date string to a Date object
            var targetDateObject = new Date(targetDate);

            // Set time to midnight for the target date
            targetDateObject.setHours(0, 0, 0, 0);

            // Compare the current date with the target date
            return currentDate > targetDateObject;
        }

        function handleInput() {
            // Get the value of the time input
            var stime = document.getElementById('stime').value;
            var etime = document.getElementById('etime').value;

            var tdate = document.getElementById('date').value;

            console.log(tdate);
            if (isDatePassed(tdate)) {
                document.getElementById('errordate').style.display="block";
            } else {
                document.getElementById('errordate').style.display="none";
            }


            if(compareTimes(stime, etime)>0||(isDatePassed(tdate))){
                document.getElementById('submitbutton').disabled = true;
            }else{
                document.getElementById('submitbutton').disabled = false;
            }
            if(compareTimes(stime, etime)>0){
                document.getElementById('show').style.display="block";
                // document.getElementById('submitbutton').disabled = true;
            }else{
                document.getElementById('show').style.display="none";
                // document.getElementById('submitbutton').disabled = false;
            }


        }
    </script>


@endsection
