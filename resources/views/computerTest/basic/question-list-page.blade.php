{{-- start --}}
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
                                    <h3 class=" display-6 text-center">Question Set List</h3>
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
                                    <table id="example1"
                                           class="table table-bordered table-striped text-center align-middle">
                                        <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th class="text-center">Question Set Name</th>
                                            <th class="text-center">Number of MCQ  Questions</th>
                                            <th class="text-center">Number of True/false  Questions</th>
                                            <th class="text-center">Number of Typing test  Questions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($questionSets!=null)
                                            @foreach($questionSets as $questionSet)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="text-left">{{ $questionSet->question_set_name }}</td> <!-- Question Set Name -->
                                                    <td>{{ $questionSet->num_of_mcq }}</td> 
                                                    <td>{{ $questionSet->num_of_true_false }}</td> 
                                                    <td>{{ $questionSet->num_of_typing_test }}</td> 
{{--                                                    <td>--}}
{{--                                                        <div class="d-flex justify-content-center">--}}
{{--                                                            <!-- Delete Button -->--}}
{{--                                                            <form id="#" >--}}

{{--                                                                <button  class="custom-btn btn btn-xs btn-danger ml-1" >--}}
{{--                                                                    <i class="bi bi-trash-fill"></i>--}}
{{--                                                                </button>--}}
{{--                                                            </form>--}}
{{--                                                            <!-- Edit Button -->--}}
{{--                                                            <a href="#" class="custom-btn btn btn-warning btn-xs ml-1">--}}
{{--                                                                <i class="bi bi-pencil-square"></i>--}}
{{--                                                            </a>--}}
{{--                                                        </div>--}}
{{--                                                    </td>--}}
                                                </tr>
                                            @endforeach
                                        @endif
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
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
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
