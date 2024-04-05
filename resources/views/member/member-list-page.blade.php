@extends('dashboard')

@section('style')
    @include('layouts.dataTable')
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
                                    <h3 class=" display-6 text-center">Member List</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div id="message-container">
                                        @if (session('success'))
                                            <div class="alert alert-danger">
                                                {{ session('success') }}
                                            </div>
                                        @endif

                                        @if (session('fail'))
                                            <div class="alert alert-danger">
                                                {{ session('fail') }}
                                            </div>
                                        @endif
                                    </div>
                                    <table id="member-list"
                                           class="table table-bordered table-striped text-center align-middle">
                                        <thead>
                                        <tr>
                                            <th>BPID</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Post</th>
                                            <th>Posting Area</th>
                                            <th>Action</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($members as $member)
                                            <tr>
                                                <td>{{ $member->bpid }}</td>
                                                <td>{{ $member->name_bn }}</td>
                                                <td>{{ $member->designation }}</td>
                                                <td>{{ $member->post }}</td>
                                                <td>{{ $member->posting_area }}</td>
                                                <td><a href="{{url('/edit-member/'.$member->id)}}" class=" custom-btn btn btn-warning btn-xs ml-1">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a></td>
                                            </tr>
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

    <script>
        $(function () {
            $("#member-list").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#member-list_wrapper .col-md-6:eq(0)');
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
