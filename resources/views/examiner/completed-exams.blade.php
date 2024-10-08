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
                                <h3 class="display-6 text-center">Completed Exam List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div id="message-container">
                                    @if (session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif
                                    @if (session('fail'))
                                        <div class="alert alert-danger">{{ session('fail') }}</div>
                                    @endif
                                </div>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Exam</th>
                                            <th>Selected Police</th>
                                            <th>Police Id</th>
                                            <th>Login Time</th>
                                            <th>Submission Time</th>
                                            <th>Marks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
@if($completedExams != null)
    @foreach($completedExams as $s)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>@if($s->config != null) @if($s->config->exam != null) {{ $s->config->exam->exam_name }} @endif @endif</td>
        <td>@if($s->member != null) {{ $s->member->name_bn }} @endif</td>
        <td>@if($s->member != null) {{ $s->member->bpid }} @endif</td>
        <td>{{ $s->login_time }}</td>
        <td>{{ $s->submission_time }}</td>
        <td>
            @if($s->is_evaluated == 'yes')
                <a href="{{ route('examiner.print-exam-result', $s->id) }}" class="btn btn-success" >
                    <i class="fas fa-check  mr-2"></i> View Result
                </a>
            @else
                <a href="{{ route('examiner.evaluate-exam', $s->id) }}" class="btn btn-primary">
                    <i class="fas fa-clipboard-list mr-2"></i> Evaluate
                </a>
            @endif
        </td>
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
