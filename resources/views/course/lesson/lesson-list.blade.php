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

    <!-- Content Wrapper. Contains page content -->
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
                        Are you sure you want to delete this lesson? This action cannot be undone.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form id="deleteLessonForm" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center mt-4">
                    <div class="col-12 justify-content-center">
                        <div class="card">
                            <div class="card-header clr-dark-green">
                                <h3 class=" display-6 text-center">Lesson List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center align-middle">
                                    <thead>
                                    <tr>
                                        <th>SL No.</th>
                                        <th>Lesson Title</th>
                                        <th>Lesson No.</th>

                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($lessons->groupBy('courses_id') as $courseLessons)
                                        <tr class="table-primary">
                                            <td colspan="5" class="text-center font-weight-bold">Course: {{ $courseLessons->first()->course->title }}</td>
                                        </tr>
                                        @foreach($courseLessons as $lesson)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $lesson->title }}</td>
                                                <td>{{ $lesson->lesson_no }}</td>

                                                <td>
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <button type="button" class="btn btn-danger btn-xs" onclick="confirmDelete({{ $lesson->id_lessons }})">
                                                            Delete
                                                        </button>
                                                        <a href="{{ url('admin/edit-lesson/' . $lesson->id_lessons) }}" class="btn btn-warning btn-xs ml-1">
                                                            Edit
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    </tbody>
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

@section('script')
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
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
    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

        function confirmDelete(lessonId) {
            // Set the form action dynamically
            var deleteForm = document.getElementById('deleteLessonForm');
            deleteForm.action = "{{ url('delete-lesson') }}/" + lessonId;

            // Show the modal
            $('#deleteConfirmationModal').modal('show');
        }
    </script>
@endsection