{{-- start --}}
@extends('dashboard')
@section('style')
    @include('layouts.dataTable')
    <link rel="stylesheet" href="{{ asset('custom/main.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

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
                                    <h3 class=" display-6 text-center">Question Set List</h3>
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


                                    <table id="chunkedTable" class="display table table-striped w-100">
                                        <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th class="text-center">Question Set Name</th>
                                            <th class="text-center">Number of MCQ Questions</th>
                                            <th class="text-center">Number of True/false Questions</th>
                                            <th class="text-center">Number of Typing test Questions</th>
                                            <th class="text-center">Actions</th>
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

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this question set?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                    </div>
                </div>
            </div>
        </div>

    @endsection

@endsection
<!-- ./wrapper -->

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
                    url: '/computer-test/basic/question-set-list-chunk',
                    type: 'GET', // Or 'GET' if you prefer
                },
                columns: [
                    {data: 'serial'},
                    {data: 'question_set_name'},
                    {data: 'num_of_mcq'},
                    {data: 'num_of_true_false'},
                    {data: 'num_of_typing_test'},
                    {
                        data: 'question_set_id',
                        render: function (data, type, row) {
                            return `
                    <a href="/computer-test/basic/question-set-edit/${data}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <button class="btn btn-danger btn-sm delete-button" data-id="${data}" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal">
                <i class="bi bi-trash"></i> Delete
            </button>
        `;
                        }
                    }

                ],
                pageLength: 10, // Number of rows per chunk
            });





        });
    </script>

    <script>
        $(document).ready(function () {
            let deleteId = null;

            // Store the ID of the question set to delete
            $(document).on('click', '.delete-button', function () {
                deleteId = $(this).data('id');
            });

            // Handle delete confirmation
            $('#confirmDelete').on('click', function () {
                if (deleteId) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: `/computer-test/basic/question-set-delete/${deleteId}`,
                        type: 'DELETE',
                        success: function (response) {
                            $('#deleteConfirmationModal').modal('hide');
                            const messageContainer = $('#message-container');

                            if (response.success) {
                                // Append success message
                                messageContainer.html(`
                            <div class="alert alert-success">${response.success}</div>
                        `);
                                // Reload the table to update the data
                                $('#chunkedTable').DataTable().ajax.reload();
                            } else {
                                // Append failure message
                                messageContainer.html(`
                            <div class="alert alert-danger">${response.error || 'Unknown error'}</div>
                        `);
                            }

                            // Automatically hide the message after 4 seconds
                            setTimeout(function () {
                                messageContainer.empty();
                            }, 4000);
                        },
                        error: function (xhr) {
                            $('#deleteConfirmationModal').modal('hide');
                            const messageContainer = $('#message-container');
                            messageContainer.html(`
                        <div class="alert alert-danger">An error occurred while deleting the question set.</div>
                    `);

                            // Automatically hide the message after 4 seconds
                            setTimeout(function () {
                                messageContainer.empty();
                            }, 4000);
                        }
                    });
                }
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



@endsection
