@extends('dashboard')
@section('main')
    @parent

    <!-- Content Wrapper. Contains page content -->
@section('edit')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create Question</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 justify-content-center">
                        <div class="card">
                            <div class="card-header">
                               
                                <h3 class="text-center display-6 mb-0">
                                    Edit Question
                                </h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('question-updated') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">

                                           <input type="hidden" name="cid" value="{{$question->id_questions}}">
                                            <!-- /.card-header -->
                                            <label for="" class="d-block">Question
                                                <textarea id="summernote" name="question">
                                                  {{$question->question}}
                                                </textarea>
                                            </label>



                                        </div>

                                        
                                        
                                        <div class="col-md-12 bg-primary p-2 m-2">
                                            <h4 class="text-center mb-0">
                                                Create Options and Choose the Correct Also
                                            </h4>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="option3" class="d-block ">
                                                 option
                                                1
                                                <input type="text" id="option3" name="a" class="form-control" value="{{$question->a}}">


                                            </label>

                                        </div>
                                        <div class="col-md-6">
                                            <label for="option3" class="d-block "> option 2
                                                <input type="text" id="option3" name="b" class="form-control" value="{{$question->b}}">


                                            </label>

                                        </div>
                                        <div class="col-md-6">
                                            <label for="option3" class="d-block "> option 3
                                                <input type="text" id="option3" name="c" class="form-control" value="{{$question->c}}">


                                            </label>

                                        </div>
                                        <div class="col-md-6">
                                            <label for="option3" class="d-block "> option 4
                                                <input type="text" id="option3" name="d" class="form-control" value="{{$question->d}}">


                                            </label>
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="d-block ">
                                                <input type="radio" id="option3" name="ans" value="a" @if('a'==$question->answer) checked / @endif> a
                                            </label>
                                            <label for="" class="d-block ">
                                                <input type="radio" id="option3" name="ans" value="b" @if('b'==$question->answer) checked / @endif> b
                                            </label>
                                            <label for="" class="d-block ">
                                                <input type="radio" id="option3" name="ans" value="c" @if('c'==$question->answer) checked / @endif> c
                                            </label>
                                            <label for="" class="d-block ">
                                                <input type="radio" id="option3" name="ans" value="d" @if('d'==$question->answer) checked / @endif> d
                                            </label>
                                           
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <button class="btn btn-md btn-primary form-control">update</button>
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
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- Summernote -->
<script src="../../plugins/summernote/summernote-bs4.min.js"></script>
<!-- CodeMirror -->
<script src="../../plugins/codemirror/codemirror.js"></script>
<script src="../../plugins/codemirror/mode/css/css.js"></script>
<script src="../../plugins/codemirror/mode/xml/xml.js"></script>
<script src="../../plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
    $(function() {
        // Summernote
        $('#summernote').summernote()

        
    })
</script>
@endsection
