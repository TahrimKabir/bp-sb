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
                            Are you sure you want to delete this course? This action cannot be undone.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <form id="deleteCourseForm" method="POST" action="">
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
                                    <h3 class=" display-6 text-center">Course List</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">


                                    <table id="chunkedTable" class="display table table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>SL No.</th>
                                                <th>Course Title</th>
                                                <th>Course No.</th>
                                                <th>Status</th>
                                                <th>Target Trainee</th>
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
                    url: '/admin/course-list-chunk',
                    type: 'GET', // Or 'GET' if you prefer
                },
                columns: [
                    { data: 'serial' },
                    { data: 'title' },
                    { data: 'course_no' },
                    { data: 'status' },
                    { data: 'target_trainee' },
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
        function confirmDelete(courseId) {
            // Set the form action dynamically
            var baseUrl = "{{ url('') }}";
            var deleteForm = document.getElementById('deleteCourseForm');
            deleteForm.action = baseUrl+'/delete-course/' + courseId;

            // Show the modal
            $('#deleteConfirmationModal').modal('show');
        }

        document.addEventListener("DOMContentLoaded", function() {

            var messageContainer = document.getElementById('message-container');


            if (messageContainer) {

                setTimeout(function() {

                    messageContainer.style.display = 'none';
                }, 4000);
            }



        });

    </script>
@endsection
