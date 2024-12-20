{{-- start --}}
@extends('dashboard')
@section('style')
    @include('layouts.dataTable')
    @php
      use  \Illuminate\Contracts\Support\Htmlable;
 @endphp
    <link rel="stylesheet" href="{{ asset('custom/main.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">



    <style>
        .custom-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            border: 1px solid transparent;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
@endsection

@section('main')
    @parent

    <!-- Content Wrapper. Contains page content -->
    @section('edit')
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center mt-4">
                        <div class="col-12 justify-content-center">
                            <div class="card">
                                <div class="card-header clr-dark-green">
                                    <h3 class=" display-6 text-center">Question List</h3>
                                </div>
                                <!-- /.card-header -->
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
                                    </div>
                                    {{-- <table id="example1"
                                           class="table table-bordered table-striped text-center align-middle">
                                        <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th class="text-center">Question</th>
                                            <th class="text-center">Option 1</th>
                                            <th class="text-center">Option 2</th>
                                            <th class="text-center">Option 3</th>
                                            <th class="text-center">Option 4</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($mcqQuestions!=null)
                                            @foreach($mcqQuestions as $key => $question)
                                                <tr class="align-middle">
                                                    <td class="p-3">{{ $loop->iteration }}</td>
                                                    <td > {!! $question->question_content !!}
                                                    </td>
                                                    <td class="p-3 @if($question->correct_answer == 1) clr-dark-green @endif"> {{$question->option1}}</td>
                                                    <td class="p-3 @if($question->correct_answer == 2) clr-dark-green @endif"> {{$question->option2}}</td>
                                                    <td class="p-3 @if($question->correct_answer == 3) clr-dark-green @endif"> {{$question->option3}}</td>
                                                    <td class="p-3 @if($question->correct_answer == 4) clr-dark-green @endif"> {{$question->option4}}</td>
                                                    <td>
                                                        <div class="col-12 d-flex justify-content-center">
                                                            <!-- Form element for deleting the question -->
                                                            <form id="deleteForm{{ $question->question_id }}" action="{{url('/computer-test/basic/mcq-question-delete/'. $question->question_id)}}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class=" custom-btn btn btn-xs btn-danger ml-1" onclick="confirmDelete({{ $question->question_id }})">
                                                                    <i class="bi bi-trash-fill"></i>
                                                                </button>
                                                            </form>
                                                            <!-- Button for editing the question -->
                                                            <a href="{{ url('/computer-test/basic/mcq-question-edit/' . $question->question_id) }}" class=" custom-btn btn btn-warning btn-xs ml-1">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </a>
                                                        </div>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>

                                    </table> --}}

                                    <table id="chunkedTable" class="display table table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>SL No.</th>
                                                <th class="text-center">Question</th>
                                                <th class="text-center">Option 1</th>
                                                <th class="text-center">Option 2</th>
                                                <th class="text-center">Option 3</th>
                                                <th class="text-center">Option 4</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>

                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
    @endsection

    <!-- ./wrapper -->
{{-- Confirmation Modal --}}
<div id="confirmationModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <p>Are you sure you want to delete this question?</p>
        <button  type="button" onclick="deleteQuestion()" class="btn btn-danger mb-1">Delete</button>
        <button type="button" onclick="closeModal()" class="btn btn-secondary">Cancel</button>
    </div>
</div>
@endsection

<!-- jQuery -->
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="../../dist/js/demo.js"></script> --}}
    <!-- Page specific script -->

    <!-- AdminLTE for demo purposes -->
    {{-- <script src="../../dist/js/demo.js"></script> --}}
    <!-- Page specific script -->
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

        $(document).ready(function () {
            $('#chunkedTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/computer-test/basic/mcq-question-list-chunk',
                    type: 'GET', // Or 'GET' if you prefer
                },
                columns: [
                    { data: 'serial' },
                    { data: 'question_content' },
                    { data: 'option1' },
                    { data: 'option2' },
                    { data: 'option3' },
                    { data: 'option4' },
                    // { data: 'correct_answer' },
                    {
                        data: 'action', 
                        orderable: false,
                        searchable: false,
                    }
                ],
                pageLength: 10, // Number of rows per chunk
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            var messageContainer = document.getElementById('message-container');


            if (messageContainer) {

                setTimeout(function () {

                    messageContainer.style.display = 'none';
                }, 4000);
            }
        });

    </script>


    <script>
        function confirmDelete(questionId) {
            console.log(questionId);
            let modal = document.getElementById('confirmationModal');
            modal.style.display = 'block';
            // Set the question ID as a data attribute in the modal for reference
            modal.setAttribute('data-question-id', questionId);
        }

        function closeModal() {
            let modal = document.getElementById('confirmationModal');
            modal.style.display = 'none';
        }

        function deleteQuestion() {
            let modal = document.getElementById('confirmationModal');
            let questionId = modal.getAttribute('data-question-id');
            let deleteForm = document.getElementById('deleteForm' + questionId);

            if (deleteForm) {
                deleteForm.submit();
            } else {
                console.error('Delete form not found for question ID: ' + questionId);
            }
        }
    </script>
@endsection
