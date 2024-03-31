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
                    <div class="col-12 justify-content-center">
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

                                <h3 class="text-center display-6 mb-0">
                                    Create Question
                                </h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('question-created') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">

                                           <input type="hidden" name="cid" value="">
                                            <!-- /.card-header -->
                                            <label for="" class="d-block">Question
                                                <textarea id="summernote" name="question" required>

                                                </textarea>
                                            </label>



                                        </div>



                                        {{-- <div class="col-md-12 bg-primary p-2 m-2">
                                            <h4 class="text-center mb-0">
                                                Create Options and Choose the Correct Also
                                            </h4>
                                        </div> --}}
                                        <div class="col-md-6">
                                            <label for="option3" class="d-block ">
                                                 Option
                                                1
                                                <input type="text" id="option3" name="a" class="form-control" value="" required>


                                            </label>

                                        </div>
                                        <div class="col-md-6">
                                            <label for="option3" class="d-block "> Option 2
                                                <input type="text" id="option3" name="b" class="form-control" value="" required>


                                            </label>

                                        </div>
                                        <div class="col-md-6">
                                            <label for="option3" class="d-block "> Option 3
                                                <input type="text" id="option3" name="c" class="form-control" value="">


                                            </label>

                                        </div>
                                        <div class="col-md-6">
                                            <label for="option3" class="d-block "> Option 4
                                                <input type="text" id="option3" name="d" class="form-control" value="">


                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="option3" class="d-block "> Option 5
                                                <input type="text" id="option3" name="e" class="form-control" value="">


                                            </label>

                                        </div>
                                        <div class="col-md-6">
                                            <label for="option3" class="d-block "> Option 6
                                                <input type="text" id="option3" name="f" class="form-control" value="">


                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="option3" class="d-block "> Correct Answer
                                                <select name="ans" id="" class="select2 form-control" required>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                </select>


                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="duration-in-seconds">Duration in Seconds</label>
                                            <input type="number" min="1"  id="duration-in-seconds" name="duration_in_seconds" class="form-control"  value="1" required />
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <button class="btn btn-sm clr-dark-green text-white form-control">Create</button>
                                        </div>
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
<script>
    $(function() {
        // Summernote
        $('#summernote').summernote()


    })
</script>
@endsection
