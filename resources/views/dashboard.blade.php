<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                use App\Models\Member;
                use App\Models\Exam_Schedule;
                use App\Models\Course;
                  $totalMembers = Member::count();
                  $totalSchedules=Exam_Schedule::count();
                  $totalCourses=Course::count();
                  $courses = Course::with('lessons')->get();


$completedExamsCount = Exam_Schedule::where('status', 'completed')->count();

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
                                                    <h5 class="border-bottom pb-1">Portal Statistics</h5>
                                                    <div class="row">
                                                        <div class="col-md-6">

                                                            <div class="card py-2"
                                                                 style="min-height: 120px;background: #F4543C;">
                                                                <div class="row">
                                                                    <div
                                                                        class="col-4 d-flex align-items-center justify-content-center">
                                                                        <i class="fas fa-users fa-2x text-white"></i>
                                                                    </div>
                                                                    <div class="col-8 d-flex align-items-center">
                                                                        <div>
                                                                            <h5 class="mt-3 text-white">Total
                                                                                Members</h5>
                                                                            <h2 class="font-weight-bold text-white">{{$totalMembers}}</h2>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6">

                                                            <div class="card py-2"
                                                                 style="min-height: 120px;background: #008D4C;">
                                                                <div class="row">
                                                                    <div
                                                                        class="col-4 d-flex align-items-center justify-content-center">
                                                                        <i class="fas fa-book fa-2x text-white"></i>

                                                                    </div>
                                                                    <div class="col-8 d-flex align-items-center">
                                                                        <div>
                                                                            <h5 class="mt-3 text-white">Total
                                                                                Courses </h5>
                                                                            <h2 class="font-weight-bold text-white">{{$totalCourses}}</h2>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6">

                                                            <div class="card py-2"
                                                                 style="min-height: 120px;background: #00ACD6;">
                                                                <div class="row">
                                                                    <div
                                                                        class="col-4 d-flex align-items-center justify-content-center">
                                                                        <i class="fas fa-calendar-alt fa-2x text-white"></i>

                                                                    </div>
                                                                    <div class="col-8 d-flex align-items-center">
                                                                        <div>
                                                                            <h5 class="mt-3 text-white">Total Scheduled
                                                                                Exams</h5>
                                                                            <h2 class="font-weight-bold text-white">{{$totalSchedules}}</h2>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6">

                                                                <div class="card py-2"
                                                                     style="min-height: 120px;background: #00639E;">
                                                                    <div class="row">
                                                                        <div
                                                                            class="col-4 d-flex align-items-center justify-content-center">
                                                                            <i class="fas fa-trophy fa-2x text-white"></i>

                                                                        </div>
                                                                        <div class="col-8 d-flex align-items-center">
                                                                            <div>
                                                                                <h5 class="text-white">Total Completed
                                                                                    exams</h5>
                                                                                <h2 class="font-weight-bold text-white">
                                                                                    {{$completedExamsCount}}</h2>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Exam Management --}}
                                                <div class="p-3 bg-white rounded">
                                                    <h5 class="border-bottom pb-1">Question Bank Management</h5>
                                                    <h5 class="pb-2 border-bottom text-secondary"> IQ Test</h5>
                                                    <div class="row">
                                                        <div class="col-md-4 d-flex align-items-center">
                                                            <h6 class="">IQ Test Questions</h6>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="{{ asset('/create-question') }}"
                                                               class="btn btn-md btn-block mb-1 text-white"
                                                               style="background:  #00ACD6;">
                                                                <i class="fas fa-plus"></i> Add Questions
                                                            </a>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="{{ asset('/questionlist') }}"
                                                               class="btn btn-md btn-block mb-1 text-white"
                                                               style="background: #00639E;">
                                                                <i class="fas fa-list-ul"></i> Questions List
                                                            </a>
                                                        </div>

                                                    </div>
                                                    <br>
                                                    {{-- Basic Computer Test --}}
                                                    <h5 class="pb-2 border-bottom text-secondary"> Basic Computer
                                                        Test</h5>
                                                    <div class="row">
                                                        <div class="col-md-4 d-flex align-items-center">
                                                            <h6 class="">Multiple Choice Questions</h6>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="{{ asset('/computer-test/basic/create-mcq-question') }}"
                                                               class="btn btn-md btn-block mb-1 text-white"
                                                               style="background:  #00ACD6;">
                                                                <i class="fas fa-plus"></i> Add Questions
                                                            </a>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="{{ asset('/computer-test/basic/mcq-question-list') }}"
                                                               class="btn btn-md btn-block mb-1 text-white"
                                                               style="background: #00639E;">
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
                                                            <a href="{{ asset('/computer-test/basic/create-true-false-question') }}"
                                                               class="btn btn-md btn-block mb-1 text-white"
                                                               style="background:  #00ACD6;">
                                                                <i class="fas fa-plus"></i> Add Questions
                                                            </a>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="{{ asset('/computer-test/basic/true-false-question-list') }}"
                                                               class="btn btn-md btn-block mb-1 text-white"
                                                               style="background: #00639E;">
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
                                                            <a href="{{ asset('/create-typing-test-question') }}"
                                                               class="btn btn-md btn-block mb-1 text-white"
                                                               style="background:  #00ACD6;">
                                                                <i class="fas fa-plus"></i> Add Questions
                                                            </a>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="{{asset('/typing-test-question-list')}}"
                                                               class="btn btn-md btn-block mb-1 text-white"
                                                               style="background: #00639E;">
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
                                                            <a href="{{ asset('/create-typing-test-question') }}"
                                                               class="btn btn-md btn-block mb-1 text-white"
                                                               style="background:  #00ACD6;">
                                                                <i class="fas fa-plus"></i> Create Question Set
                                                            </a>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="{{asset('/computer-test/basic/question-set-list')}}"
                                                               class="btn btn-md btn-block mb-1 text-white"
                                                               style="background: #00639E;">
                                                                <i class="fas fa-list-ul"></i> Question Set List
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <br>
                                                    {{-- Advanced Computer Test --}}
                                                    <h5 class="pb-2 border-bottom text-secondary fw-bold"> Advanced
                                                        Computer Test</h5>
                                                    <div class="row">
                                                        <div class="col-md-4 d-flex align-items-center">
                                                            <h6 class="">Question Sets</h6>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="{{ asset('/create-computer-test-question') }}"
                                                               class="btn btn-md btn-block mb-1 text-white"
                                                               style="background:  #00ACD6;">
                                                                <i class="fas fa-plus"></i> Create Question Set
                                                            </a>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="{{ asset('/computer-test-question-list') }}"
                                                               class="btn btn-md btn-block mb-1 text-white"
                                                               style="background: #00639E;">
                                                                <i class="fas fa-list-ul"></i> Questions List
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>

                                            {{-- Right --}}
                                            <div class="col-md-6">
                                                {{-- Quick Links --}}
                                                <div class="py-2 px-0 rounded">
                                                    <h5 class="border-bottom pb-1">Quick Links</h5>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <a href="{{ asset('/create-schedule') }}">
                                                                <div class="card p-0">
                                                                    <div
                                                                        class="card-body d-flex align-items-center justify-content-center p-3">
                                                                        <i class="fas fa-calendar-alt fa-2x text-primary"></i>
                                                                    </div>
                                                                    <div
                                                                        class="card-footer text-center bg-white rounded px-0 mx-0">
                                                                        <span
                                                                            class="text-secondary">Exam Schedule</span>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <a href="{{ asset('/schedule-list') }}">
                                                                <div class="card p-0">
                                                                    <div
                                                                        class="card-body d-flex align-items-center justify-content-center p-3">
                                                                        <i class="fas fa-list-alt fa-2x text-warning"></i>
                                                                    </div>
                                                                    <div
                                                                        class="card-footer text-center bg-white rounded px-0 mx-0">
                                                                        <span
                                                                            class="text-secondary">Schedule List</span>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <a href="{{ asset('/add-member') }}">
                                                                <div class="card p-0">
                                                                    <div
                                                                        class="card-body d-flex align-items-center justify-content-center p-3">
                                                                        <i class="fas fa-user-plus fa-2x"
                                                                           style="color:#A850FF;"></i>
                                                                    </div>
                                                                    <div
                                                                        class="card-footer text-center bg-white rounded px-0 mx-0">
                                                                        <span class="text-secondary">Add Member</span>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <a href="{{ asset('/member-list') }}">
                                                                <div class="card p-0">
                                                                    <div
                                                                        class="card-body d-flex align-items-center justify-content-center p-3">
                                                                        <i class="fas fa-users fa-2x text-info"></i>
                                                                    </div>
                                                                    <div
                                                                        class="card-footer text-center bg-white rounded px-0 mx-0">
                                                                        <span class="text-secondary">Member List</span>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Course Management --}}
                                                {{-- Course Management --}}
                                                <div class="p-3 bg-white rounded">
                                                    <h5 class="border-bottom pb-1">Course Management</h5>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="accordion" id="accordionExample">
                                                                @foreach ($courses as $course)
                                                                    <div class="card my-2">
                                                                        <div class="card-header" id="heading{{ $course->id_courses }}">
                                                                            <h2 class="mb-0">
                                                                                <button class="btn btn-link btn-block text-left text-dark font-weight-bold" type="button" data-toggle="collapse" data-target="#collapse{{ $course->id_courses }}" aria-expanded="false" aria-controls="collapse{{ $course->id_courses }}">
                                                                                    {{ $course->title }}
                                                                                    <i class="fas fa-chevron-right float-right"></i>
                                                                                </button>
                                                                            </h2>
                                                                        </div>

                                                                        <div id="collapse{{ $course->id_courses }}" class="collapse" aria-labelledby="heading{{ $course->id_courses }}" data-parent="#accordionExample">
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col-md-4">
                                                                                        <a href="{{url('admin/lesson-list/' . $course->id_courses)}}">
                                                                                            <div class="card text-white" style="background: #e06b1e;">
                                                                                                <div class="row card-body p-2 d-flex align-items-center">
                                                                                                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                                                                                                        <i class="fa fa-list-alt fa-2x" aria-hidden="true"></i>
                                                                                                    </div>
                                                                                                    <div class="col-md-9 d-flex align-items-center justify-content-center">
                                                                                                        <h6 class="pt-2">Lesson Plan Management</h6>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </a>
                                                                                    </div>

                                                                                    <div class="col-md-4">
                                                                                        <a href="{{ url('admin/material-list?course_filter=' . $course->id_courses) }}">
                                                                                            <div class="card" style="background: #9149F0;">
                                                                                                <div class="row card-body p-2 d-flex align-items-center">
                                                                                                    <div class="col-md-3 d-flex align-items-center justify-content-center text-white">
                                                                                                        <i class="fas fa-cog fa-2x" aria-hidden="true"></i>
                                                                                                    </div>
                                                                                                    <div class="col-md-9 d-flex align-items-center justify-content-center">
                                                                                                        <h6 class="text-white pt-2">Manage Course Materials</h6>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </a>
                                                                                    </div>

                                                                                    <div class="col-md-4">
                                                                                        <a href="#">
                                                                                            <div class="card" style="background: #00639e;">
                                                                                                <div class="row card-body p-2 d-flex align-items-center">
                                                                                                    <div class="col-md-3 d-flex align-items-center justify-content-center text-white">
                                                                                                        <i class="fas fa-cog fa-2x" aria-hidden="true"></i>
                                                                                                    </div>
                                                                                                    <div class="col-md-9 d-flex align-items-center justify-content-center">
                                                                                                        <h6 class="text-white pt-2">Quiz Ques. Configuration</h6>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
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
