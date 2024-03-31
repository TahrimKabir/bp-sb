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
                                        Edit Question
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ url('/update-typing-test-question') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="question_id" value="{{$question->question_id}}">
                                        <div class="form-group">
                                            <label for="question-content">Question Content</label>
                                            <textarea  id="question-content" name="question_content" class="form-control"  rows="5"  required  >{{$question->content}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="duration-in-seconds">Duration in Seconds</label>
                                            <input type="number" min="1"  id="duration-in-seconds" name="duration_in_seconds" class="form-control"  value="{{$question->time_in_seconds}}" required />
                                        </div>
                                        @error('question_content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg clr-dark-green text-white">Update</button>
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

    <!-- AdminLTE for demo purposes -->
    {{-- <script src="../../dist/js/demo.js"></script> --}}
    <!-- Page specific script -->

@endsection
