{{-- start --}}
@extends('dashboard')
@section('style')
    @include('layouts.dataTable')
    <link rel="stylesheet" href="{{ asset('custom/main.css') }}">
@endsection

@section('main')
    @parent

    <!-- Content Wrapper. Contains page content -->
    @section('edit')
        <div class="content-wrapper">

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                Are you sure you want to delete this Question? This action cannot be undone.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <form id="deleteQuestionForm" method="POST" action="">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
                                    {{-- <table id="example1" class="table table-bordered table-striped text-center align-middle" >
                                        <thead>
                                        <tr >
                                            <th>SL No.</th>
                                            <th class="text-left">Question</th>
                                            <th>Option_a</th>
                                            <th>Option_b</th>
                                            <th>Option_c</th>
                                            <th>Option_d</th>

                                            <th>correct Option</th>
                                            <th >Course</th>
                                            <th >Lesson</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($quizQuestions!=null)
                                            @foreach($quizQuestions as $question)
                                                <tr class="align-middle">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="text-left">  {!! $question->question !!}
                                                    </td>
                                                    <td class="align-middle @if($question->answer=='a') clr-dark-green @endif ">{{$question->a}}</td>
                                                    <td class="align-middle @if($question->answer=='b') clr-dark-green @endif ">{{$question->b}}</td>
                                                    <td class="align-middle @if($question->answer=='c') clr-dark-green @endif ">{{$question->c}}</td>
                                                    <td class="align-middle @if($question->answer=='d') clr-dark-green @endif ">{{$question->d}}</td>

                                                    <td>{{$question->answer}}</td>
                                                    <td>{{$question->course->title}}</td>
                                                    <td>{{$question->lesson->title}}</td>
                                                    <td>
                                                        <div class="col-12 d-flex justify-content-center">

                                                                <button type="button" class="btn btn-danger btn-xs" onclick="confirmDelete({{ $question->question_id }})">
                                                                    Delete
                                                                </button>
                                                                <a href="{{ url('admin/edit-quiz-question/' . $question->question_id) }}" class="btn btn-warning btn-xs ml-1">
                                                                    Edit
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
                                                <th class="text-left">Question</th>
                                                <th>Option_a</th>
                                                <th>Option_b</th>
                                                <th>Option_c</th>
                                                <th>Option_d</th>
                                                <th>correct Option</th>
                                                <th >Course</th>
                                                <th >Lesson</th>
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

@endsection
<!-- ./wrapper -->

<!-- jQuery -->
@section('script')
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
        $(function() {
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
                    url: '/admin/quiz-question-list-chunk',
                    type: 'GET', // Or 'GET' if you prefer
                },
                columns: [
                    { data: 'serial' },
                    { data: 'question' },
                    { data: 'a' },
                    { data: 'b' },
                    { data: 'c' },
                    { data: 'd' },
                    { data: 'answer' },
                    { data: 'course_title' },
                    { data: 'lesson_title' },
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
        document.addEventListener("DOMContentLoaded", function() {

            var messageContainer = document.getElementById('message-container');


            if (messageContainer) {

                setTimeout(function() {

                    messageContainer.style.display = 'none';
                }, 4000);
            }
        });

        function confirmDelete(id){
            let deleteForm=document.getElementById('deleteQuestionForm');
            deleteForm.action="{{url('admin/delete-quiz-question')}}/"+id;
            $('#deleteConfirmationModal').modal('show');

        }

    </script>
@endsection
