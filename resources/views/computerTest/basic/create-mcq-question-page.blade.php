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
                                <div class="card-header clr-dark-green">

                                    <h3 class="text-center display-6 mb-0">
                                        Create MCQ Question
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{url('/computer-test/basic/store-mcq-question')}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">

                                                <input type="hidden" name="cid" value="">
                                                <!-- /.card-header -->
                                                <label for="" class="d-block">Question
                                                    <textarea id="summernote" name="question_content" required>

                                                </textarea>
                                                </label>



                                            </div>

                                            <div class="col-md-6">
                                                <label for="option3" class="d-block ">
                                                    Option
                                                    1
                                                    <input type="text" id="option1" name="option1" class="form-control" value="" required>

                                                </label>

                                            </div>
                                            <div class="col-md-6">
                                                <label for="option3" class="d-block "> Option 2
                                                    <input type="text" id="option2" name="option2" class="form-control" value="" required>


                                                </label>

                                            </div>
                                            <div class="col-md-6">
                                                <label for="option3" class="d-block "> Option 3
                                                    <input type="text" id="option3" name="option3" class="form-control" value="" required>


                                                </label>

                                            </div>
                                            <div class="col-md-6">
                                                <label for="option3" class="d-block "> Option 4
                                                    <input type="text" id="option4" name="option4" class="form-control" value="" required>


                                                </label>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="correct_answer" class="d-block "> Correct Answer
                                                    <select name="correct_answer" id="" class="select2 form-control" required>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                    </select>


                                                </label>
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

    <script>
        $(function() {
            // Summernote
            $('#summernote').summernote()


        })
    </script>
@endsection
