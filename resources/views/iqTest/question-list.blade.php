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
                                            <th>Option1</th>
                                            <th>Option2</th>
                                            <th>Option3</th>
                                            <th>Option4</th>
                                            <th>Option5</th>
                                            <th>Option6</th>
                                            <th>correct Option</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     @if($question!=null)
                                     @foreach($question as $q)
                                     <tr class="align-middle">
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-left">  {!! $q->question !!}
                                        </td>
                                        <td class="align-middle @if($q->correct_option==1) clr-dark-green @endif ">{{$q->option1}}</td>
                                        <td class="align-middle @if($q->correct_option==2) clr-dark-green @endif ">{{$q->option2}}</td>
                                        <td class="align-middle @if($q->correct_option==3) clr-dark-green @endif ">{{$q->option3}}</td>
                                        <td class="align-middle @if($q->correct_option==4) clr-dark-green @endif ">{{$q->option4}}</td>
                                        <td class="align-middle @if($q->correct_option==5) clr-dark-green @endif ">{{$q->option5}}</td>
                                        <td class="align-middle @if($q->correct_option==6) clr-dark-green @endif ">{{$q->option6}}</td>
                                        <td>{{$q->correct_option}}</td>

                                        <td>
                                            <div class="col-12 d-flex justify-content-center">
                                                <a href="{{asset('/delete/question/'.$q->question_id)}}" class="btn btn-xs btn-danger">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                                        <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5zm13-3H1v2h14zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                                                      </svg>
                                                </a>
                                                <a href="{{asset('/edit/question/'.$q->question_id)}}" class="btn btn-warning btn-xs ml-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                      </svg>
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
                                            <th>Option1</th>
                                            <th>Option2</th>
                                            <th>Option3</th>
                                            <th>Option4</th>
                                            <th>Option5</th>
                                            <th>Option6</th>
                                            <th>correct Option</th>
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
                    url: '/questionlist-chunk',
                    type: 'GET', // Or 'GET' if you prefer
                },
                columns: [
                    { data: 'serial' },
                    { data: 'question' },
                    { data: 'option1' },
                    { data: 'option2' },
                    { data: 'option3' },
                    { data: 'option4' },
                    { data: 'option5' },
                    { data: 'option6' },
                    { data: 'correct_option' },
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

</script>
@endsection
