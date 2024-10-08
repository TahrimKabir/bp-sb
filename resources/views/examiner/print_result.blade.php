{{-- start --}}
@extends('dashboard')
@section('style')
    @include('layouts.dataTable')
    <link rel="stylesheet" href="{{ asset('custom/main.css') }}">
    <style>
        /* Print styles */
        @media print {
            button {
                display: none; /* Hide buttons when printing */
            }
            nav, .navbar { /* Adjust this selector to match your navbar class or ID */
                display: none; /* Hide the navigation bar when printing */
            }
        }

        .result-table {
            width: 50%;
            margin: 0 auto 20px;
            border-collapse: collapse;
        }

        .result-table th, .result-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .result-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .status-pass {
            color: green;
            font-weight: bold;
        }

        .status-fail {
            color: red;
            font-weight: bold;
        }
    </style>
@endsection

@section('main')
    @parent

    <!-- Content Wrapper. Contains page content -->
    @section('edit')
        <div class="content-wrapper p-4">
            <!-- Content Header (Page header) -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid px-5">
                    <h2 class="text-center mb-4">Test Results</h2>

                    <!-- Exam Details -->
                    <div class="text-center mb-4">
                        <h4 class="text-uppercase">{{ $examSchedule->config->exam->exam_name }}</h4>
                        <p><strong>Member Name:</strong> {{ $examSchedule->member->name_bn }} (BPID: {{ $examSchedule->member->bpid }})</p>
                        <p><strong>Exam Date:</strong> {{ \Carbon\Carbon::parse($examSchedule->config->exam->date)->format('F j, Y') ?? 'Exam Date' }}</p>
                    </div>

                    <!-- Result Summary Table -->
                    <table class="result-table mt-3 table-striped">
                        <thead>
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
                                <td>{!!$history->given_answer !!}</td>
                                <td>{{ $history->marks }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <!-- Print and Download Buttons -->
                    <div class="text-center mb-4">
                        <button class="btn btn-primary me-2" onclick="window.print()">Print Results</button>
                        <button class="btn btn-secondary" id="downloadBtn">Download Results</button>
                    </div>
                </div>
            </section>
        </div>
    @endsection
@endsection


<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include DOMPurify -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.1/purify.min.js"></script>
<!-- Include jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<!-- Include html2canvas -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


<script>
    $(document).ready(function() {
        // Download button functionality
        $('#downloadBtn').on('click', function() {
            const { jsPDF } = window.jspdf; // Access jsPDF
            const doc = new jsPDF();
            const resultsContent = $('.container').html(); // Get the results HTML content

            // Sanitize the HTML content
            const sanitizedContent = DOMPurify.sanitize(resultsContent);

            doc.html(sanitizedContent, {
                callback: function(doc) {
                    doc.save('test_result.pdf'); // Download the PDF
                },
                x: 10,
                y: 10
            });
        });
    });
</script>

