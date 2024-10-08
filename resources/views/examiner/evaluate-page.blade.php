{{-- start --}}


@extends('dashboard')
@section('style')
    @include('layouts.dataTable')
    <link rel="stylesheet" href="{{ asset('custom/main.css') }}">
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Attach event listeners to all marks input fields
            const markInputs = document.querySelectorAll('input[name^="marks"]');

            markInputs.forEach(input => {
                // Create a div for the error message
                const errorMessage = document.createElement('div');
                errorMessage.className = 'text-danger mt-1 error-message';
                errorMessage.style.display = 'none'; // Initially hidden
                input.parentNode.appendChild(errorMessage);

                input.addEventListener('input', function () {
                    const totalMarks = parseInt(this.getAttribute('data-total-marks'));
                    const givenMarks = parseInt(this.value);

                    if (givenMarks > totalMarks) {
                        errorMessage.textContent = `Marks cannot exceed the total marks of ${totalMarks} for this question.`;
                        errorMessage.style.display = 'block'; // Show the error message
                        this.value = totalMarks; // Reset to total marks
                    } else {
                        errorMessage.style.display = 'none'; // Hide the error message if valid
                    }
                });
            });
        });
    </script>
@endsection

@section('main')
    @parent

    <!-- Content Wrapper. Contains page content -->
@section('edit')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center mt-4">
                    <div class="col-12 col-md-10">
                        <div class="card shadow-lg">
                            <div class="card-header clr-dark-green">
                                <h3 class="display-6 text-center">Evaluate Exam</h3>
                            </div>

                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                @if (session('fail'))
                                    <div class="alert alert-danger">{{ session('fail') }}</div>
                                @endif

                                <h4>Exam: {{ $examSchedule->config->exam->exam_name }}</h4>
                                <h5>Member: {{ $examSchedule->member->name_bn }} (BPID: {{ $examSchedule->member->bpid }})</h5>

                                <form method="POST" action="{{ url('/examiner/submit-evaluation/' . $examSchedule->id) }}">
                                    @csrf

                                    <table class="table table-striped table-bordered mt-3">
                                        <thead class="clr-dark-green">
                                            <tr>
                                                <th>SL</th>
                                                <th>Question</th>
                                                <th>Question Type</th>
                                                <th>Given Answer</th>
                                                <th>Marks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($testHistory as $history)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{!! $history->computerTestQuestion->question_content !!}</td>
                                                    <td>{{ ucfirst($history->computerTestQuestion->question_type) }}</td>
                                                    <td>
                                                        @if ($history->computerTestQuestion->question_type == 'mcq')
                                                            @php
                                                                // Get the option based on the given answer
                                                                $givenAnswer = $history->given_answer; // This should be the option number
                                                                $optionField = 'option' . $givenAnswer;
                                                                $givenAnswerText = $history->computerTestQuestion->$optionField ?? 'Not Selected';
                                                            @endphp
                                                            {!! $givenAnswerText !!}
                                                        @else
                                                            {!! $history->given_answer !!}
                                                        @endif
                                                    </td>
                                                    <td class="marks-cell">
                                                        @if ($history->computerTestQuestion->question_type == 'descriptive' || $history->computerTestQuestion->question_type == 'short_question')
                                                            <input type="number" name="marks[{{ $history->id }}]" value="{{ $history->marks }}" class="form-control" required data-total-marks="{{ $history->computerTestQuestion->marks }}">
                                                        @else
                                                            {{ $history->marks }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-success btn-lg">Submit Evaluation</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@endsection
