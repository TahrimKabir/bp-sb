
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
                            <li class="breadcrumb-item active">Exam Schedule : {{$course->title}}</li>
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
                                <h1 class="display-6 text-center">{{ $course->title }}</h1>
                                <h3 class="text-center display-6 mb-0">
                                    Create Exam Schedule
                                </h3>
                            </div>
                            <div class="card-body">
                                <form action="{{route('schedule-created')}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="" class="d-block">Selected Students</label>
                                            @if ($course->Cstatus != null)
                                                @foreach ($course->Cstatus as $cs)
                                                    @if ($cs->exam == 0)
                                                        <label for="option3">
                                                            <input type="checkbox" id="option3" name="bpid[]"
                                                                value="{{ $cs->id_members_course_status }}" checked>
                                                            {{ $cs->bpid }}
        
                                                        </label>
                                                        <br>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
        
                                        <div class="col-md-6">
                                            <label for="" class="d-block">Date
                                                <input type="date" name="examdate" id="" class="form-control"></label>
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <label for="" class="d-block">from
                                                <input type="time" name="from" id="" class="form-control"></label>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="" class="d-block">to
                                                <input type="time" name="to" id="" class="form-control"></label>
                                        </div>
        
                                        <div class="col-md-2">
                                            <button class="btn btn-md btn-primary form-control">create</button>
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
@parent
@endsection

