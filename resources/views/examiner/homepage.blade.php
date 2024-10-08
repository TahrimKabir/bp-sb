<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BP SB Course</title>
  <link rel="shortcut icon" href="{{asset('images/logo.png')}}" type="image/x-icon">
@section('style')
@yield('style')
@include('layouts.style')
@show
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
    @section('main')

  <!-- Preloader -->
  @include('layouts.preloader')

  <!-- Navbar -->
  @include('layouts.nav')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  @section('edit')
  @yield('edit')

  @php
  use App\Models\Exam_Schedule as ExamSchedule;

$completedIQTestsCount = ExamSchedule::whereHas('config.exam', function($query) {
    $query->where('type', 'iq_test');
})->where('status', 'completed')->count();

$basicComputerTestCount = ExamSchedule::whereHas('config.exam', function($query) {
    $query->where('type', 'basic_computer_test');
})->where('status', 'completed')->count();

$advancedComputerTestCount = ExamSchedule::whereHas('config.exam', function($query) {
    $query->where('type', 'advanced_computer_test');
})->where('status', 'completed')->count();

$pending = ExamSchedule::whereHas('config.exam', function($query) {
    $query->where('type', 'advanced_computer_test');
})->where('status', 'completed')
  ->where('is_evaluated', 'no') 
  ->count();


@endphp
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-12">
            <!-- small box -->
            <div class="card border-0 box-shadow-0 mx-3 mt-3">
                <div class="card-header clr-dark-green text-center">
                  <h3 class="display-6"> Welcome, {{Auth::user()->name }}!!!</h3>
                </div>
                <div class="card-body p-3" style="background: #F4F6F9;">
                    <div class="row">
                        {{-- Left --}}
                        <div class="col-md-6">
                            {{-- Portal Statistics --}}
                            <div class="p-2 rounded">
                                <h5 class="border-bottom pb-1">Completed Exams</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                       
                                            <div class="card py-2" style="min-height: 120px;background: #F4543C;">
                                                <div class="row">
                                                    <div class="col-4 d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-brain fa-2x text-white"></i>

                                                    </div>
                                                    <div class="col-8 d-flex align-items-center">
                                                        <div>
                                                            <h5 class="mt-3 text-white">IQ Test</h5>
                                                            <h2 class="font-weight-bold text-white">{{$completedIQTestsCount}}</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                       
                                            <div class="card py-2" style="min-height: 120px;background: #008D4C;">
                                                <div class="row">
                                                    <div class="col-4 d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-desktop fa-2x text-white"></i>

                                                    </div>
                                                    <div class="col-8 d-flex align-items-center">
                                                        <div>
                                                            <h5 class="mt-3 text-white">Basic Computer Test</h5>
                                                            <h2 class="font-weight-bold text-white">{{$basicComputerTestCount}}</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                       
                                            <div class="card py-2" style="min-height: 120px;background: #00ACD6;">
                                                <div class="row">
                                                    <div class="col-4 d-flex align-items-center justify-content-center">
                                                    

                                                    <i class="fas fa-microchip fa-2x text-white"></i>

                                                    </div>
                                                    <div class="col-8 d-flex align-items-center">
                                                        <div>
                                                            <h5 class="mt-3 text-white">Advanced Computer Test</h5>
                                                            <h2 class="font-weight-bold text-white">{{$advancedComputerTestCount}}</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ asset('/examiner/completed-exams') }}">
                                            <div class="card py-2" style="min-height: 120px;background: #00639E;">
                                                <div class="row">
                                                    <div class="col-4 d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-hourglass-half fa-2x text-white"></i>

                                                    </div>
                                                    <div class="col-8 d-flex align-items-center">
                                                        <div>
                                                            <h5 class="text-white">Evaluation Pending</h5>
                                                            <h2 class="font-weight-bold text-white">{{$pending}}</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                           
                        </div>

                        {{-- Right --}}
                        <div class="col-md-6">
                           

                        {{-- Exam Management --}}
                            <div class="p-3 bg-white rounded">
                                <h5 class="border-bottom pb-1">Question Bank Management</h5>
                                <h5 class="pb-2 border-bottom text-secondary"> IQ Test</h5>
                                <div class="row">
                                <div class="col-md-4 d-flex align-items-center">
                                        <h6 class="">IQ Test Questions</h6>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{ asset('/create-question') }}" class="btn btn-md btn-block mb-1 text-white" style="background:  #00ACD6;">
                                            <i class="fas fa-plus"></i> Add Questions
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{ asset('/questionlist') }}" class="btn btn-md btn-block mb-1 text-white" style="background: #008D4C;">
                                            <i class="fas fa-list-ul"></i> Questions List
                                        </a>
                                    </div>
                                    
                                </div>
                                <br>
                                {{-- Basic Computer Test --}}
                                <h5 class="pb-2 border-bottom text-secondary"> Basic Computer Test</h5>
                                <div class="row">
                                    <div class="col-md-4 d-flex align-items-center">
                                        <h6 class="">Multiple Choice Questions</h6>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{ asset('/computer-test/basic/create-mcq-question') }}" class="btn btn-md btn-block mb-1 text-white" style="background:  #00ACD6;">
                                            <i class="fas fa-plus"></i> Add Questions
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{ asset('/computer-test/basic/mcq-question-list') }}" class="btn btn-md btn-block mb-1 text-white" style="background: #00639E;">
                                            <i class="fas fa-list-ul"></i> Questions List
                                        </a>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 d-flex align-items-center">
                                        <h6 class="">True/False Questions</h6>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{ asset('/computer-test/basic/create-true-false-question') }}" class="btn btn-md btn-block mb-1 text-white" style="background:  #00ACD6;">
                                            <i class="fas fa-plus"></i> Add Questions
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{ asset('/computer-test/basic/true-false-question-list') }}" class="btn btn-md btn-block mb-1 text-white" style="background: #00639E;">
                                            <i class="fas fa-list-ul"></i> Questions List
                                        </a>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 d-flex align-items-center">
                                        <h6 class="">Typing Questions</h6>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{ asset('/create-typing-test-question') }}" class="btn btn-md btn-block mb-1 text-white" style="background:  #00ACD6;">
                                            <i class="fas fa-plus"></i> Add Questions
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{asset('/typing-test-question-list')}}" class="btn btn-md btn-block mb-1 text-white" style="background: #00639E;">
                                            <i class="fas fa-list-ul"></i> Questions List
                                        </a>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 d-flex align-items-center">
                                        <h6 class="">Question Sets</h6>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{ asset('/create-typing-test-question') }}" class="btn btn-md btn-block mb-1 text-white" style="background:  #00ACD6;">
                                            <i class="fas fa-plus"></i> Create Question Set
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{asset('/computer-test/basic/question-set-list')}}" class="btn btn-md btn-block mb-1 text-white" style="background: #00639E;">
                                            <i class="fas fa-list-ul"></i> Question Set List
                                        </a>
                                    </div>
                                </div>

                                <br>
                                {{-- Advanced Computer Test --}}
                                <h5 class="pb-2 border-bottom text-secondary fw-bold"> Advanced Computer Test</h5>
                                <div class="row">
                                <div class="col-md-4 d-flex align-items-center">
                                        <h6 class="">Question Sets</h6>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{ asset('/create-computer-test-question') }}" class="btn btn-md btn-block mb-1 text-white" style="background:  #00ACD6;">
                                            <i class="fas fa-plus"></i> Create Question Set
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{ asset('/computer-test-question-list') }}" class="btn btn-md btn-block mb-1 text-white" style="background: #008D4C;">
                                            <i class="fas fa-list-ul"></i> Questions List
                                        </a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  @show
  <!-- /.content-wrapper -->
  @include('layouts.footer')
</div>
@show
<!-- ./wrapper -->

<!-- jQuery -->
@section('script')
@yield('script')
@include('layouts.script')
@show
</body>
</html>
