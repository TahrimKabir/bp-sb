
{{-- start --}}
@extends('dashboard')
@section('style')
@parent
@endsection

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
                            <li class="breadcrumb-item active">Course List</li>
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
                             Course List
                          </h3>
                         </div>
                         <div class="card-body">
                             <table class="table table-bordered">
                             <thead>
                                 <tr>
                                     <th>SL</th>
                                     <th>Course Title</th>
                                     <th>Schedule</th>
                                     <th>Question</th>
                                     <th>View Question List</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach($course as $c)
                                 <tr>
                                  <td>{{$c->id_courses}}</td>
                                 <td>{{$c->title}}</td>
                                 <td> <a href="{{asset('create-schedule/'.$c->id_courses)}}" class="btn btn-sm btn-primary">create schedule</a> </td>
                                 <td> <a href="{{asset('create-question/'.$c->id_courses)}}" class="btn btn-sm btn-primary">create question</a> </td> 
                                 <td> <a href="{{asset('question/'.$c->id_courses)}}" class="btn btn-sm btn-primary">View Question list</a> </td> </td>   
                             </tr>
                                 @endforeach
                             </tbody>
                             </table>
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
