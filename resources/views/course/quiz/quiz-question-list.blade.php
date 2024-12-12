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
            <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog"
                 aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
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
                                <div class="card-header clr-dark-green text-center">
                                    <h2 class="display-5 mb-3">Quiz Questions</h2>
                                    <h5 class="mb-0">
        <span style="font-size: 1.5rem; font-weight: bold; color: #ffc107; text-transform: uppercase;">
            Course:
        </span>
                                        <span class="text-white"
                                              style="font-size: 1.25rem;">{{ $lesson->course->title }}</span>
                                    </h5>
                                      <h5>
                                        <span
                                            style="font-size: 1.5rem; font-weight: bold; color: #ffc107; text-transform: uppercase;">
            Lesson:
        </span>
                                        <span class="text-white" style="font-size: 1.25rem;">{{ $lesson->title }}</span>
                                    </h5>
                                </div>


                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="mt-3 mb-3 mx-3 text-lg-right">
                                        <a href="{{ url('admin/create-quiz-question/'.$lesson->id_lessons) }}" class="btn btn-success btn-lg">
                                            <i class="fas fa-plus-circle mr-2"></i> Add New Question
                                        </a>
                                    </div>

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
                                            <th>Course</th>
                                            <th>Lesson</th>
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
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

        $(document).ready(function () {
            var lessonId = {{ $lesson->id_lessons }}; // Pass lesson ID from the view

            $('#chunkedTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/admin/quiz-question-list-chunk/' + lessonId,
                    type: 'GET',
                },
                columns: [
                    {data: 'serial'},
                    {data: 'question'},
                    {data: 'a'},
                    {data: 'b'},
                    {data: 'c'},
                    {data: 'd'},
                    {data: 'answer'},
                    {data: 'course_title'},
                    {data: 'lesson_title'},
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

        function confirmDelete(id) {
            let deleteForm = document.getElementById('deleteQuestionForm');
            deleteForm.action = "{{url('admin/delete-quiz-question')}}/" + id;
            $('#deleteConfirmationModal').modal('show');

        }

    </script>
@endsection
