@extends('dashboard')

@section('main')
    @parent

    <!-- Content Wrapper. Contains page content -->
    @section('edit')
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content p-4">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
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
                                <div class="card-header clr-dark-green">
                                    <h3 class="text-center display-6 mb-0 text-white">
                                        Create Question
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ url('/store-typing-test-question') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="question-content">Question Content</label>
                                            <textarea  id="question-content" name="question_content" class="form-control" rows="5" required ></textarea>
                                        </div>
                                        @error('question_content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg clr-dark-green text-white">Create</button>
                                        </div>
                                    </form>
                                </div>
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
    <!-- jQuery -->
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
    <!-- Summernote -->
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- CodeMirror -->
    <script src="{{asset('plugins/codemirror/codemirror.js')}}"></script>
    <script src="{{asset('plugins/codemirror/mode/css/css.js')}}"></script>
    <script src="{{asset('plugins/codemirror/mode/xml/xml.js')}}"></script>
    <script src="{{asset('plugins/codemirror/mode/htmlmixed/htmlmixed.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="../../dist/js/demo.js"></script> --}}
    <!-- Page specific script -->

@endsection
