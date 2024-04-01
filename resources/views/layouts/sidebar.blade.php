<aside class="main-sidebar sidebar-dark-primary elevation-4">


    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center">
            <div class="image">
                <img src="{{ asset('images/logo.png') }}" class="" alt="User Image">`
            </div>

        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ asset('/home') }}" @if(request()->segment(1) == 'home')class="nav-link text-success"
                       @else class="nav-link" @endif >
                        {{-- active --}}
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
                <li @if(request()->segment(1) == 'home'||request()->segment(1)=='create-question'||request()->segment(1)=='questionlist') class="nav-item menu-open"
                    @else class="nav-item" @endif>
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            MCQ Question
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ asset('/create-question') }}"
                               @if(request()->segment(1) == 'create-question') class="nav-link text-success"
                               @else class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Question</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{asset('/questionlist')}}"
                               @if(request()->segment(1) == 'questionlist') class="nav-link text-success"
                               @else class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Question List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li @if(request()->segment(1) == 'home'||request()->segment(1)=='create-typing-test-question'||request()->segment(1)=='typing-test-question-list') class="nav-item menu-open"
                    @else class="nav-item" @endif>
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Typing Test
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>


                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ asset('/create-typing-test-question') }}"
                               @if(request()->segment(1) == 'create-typing-test-question') class="nav-link text-success"
                               @else class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Question</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{asset('/typing-test-question-list')}}"
                               @if(request()->segment(1) == 'typing-test-question-list') class="nav-link text-success"
                               @else class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Question List</p>
                            </a>
                        </li>
                    </ul>
                </li>
{{--                Computer Test--}}
                <li @if(request()->segment(1) == 'home'||request()->segment(1)=='create-computer-test-question'||request()->segment(1)=='computer-test-question-list') class="nav-item menu-open"
                    @else class="nav-item" @endif>
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Computer Test
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ asset('/create-computer-test-question') }}"
                               @if(request()->segment(1) == 'create-computer-test-question') class="nav-link text-success"
                               @else class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Question Set</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{asset('/computer-test-question-list')}}"
                               @if(request()->segment(1) == 'computer-test-question-list') class="nav-link text-success"
                               @else class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Question List</p>
                            </a>
                        </li>

                    </ul>
                </li>
{{--                 exam --}}
                <li @if(request()->segment(1) == 'create-exam'||request()->segment(1)=='exam-list') class="nav-item menu-open"
                    @else class="nav-item" @endif>
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Exam
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ asset('/create-exam') }}"
                               @if(request()->segment(1) == 'create-exam')class="nav-link text-success"
                               @else class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Exam</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('/exam-list') }}"
                               @if(request()->segment(1) == 'exam-list')class="nav-link text-success"
                               @else class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Exam List</p>
                            </a>
                        </li>
                    </ul>

                </li>
                {{-- schedule --}}
                <li @if(request()->segment(1) == 'create-schedule'||request()->segment(1)=='schedule-list') class="nav-item menu-open"
                    @else class="nav-item" @endif>
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Exam Schedule
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ asset('/create-schedule') }}"
                               @if(request()->segment(1) == 'create-schedule') class="nav-link text-success"
                               @else class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fix Schedule</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('/schedule-list') }}"
                               @if(request()->segment(1) == 'schedule-list') class="nav-link text-success"
                               @else class="nav-link" @endif>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Schedule List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- logout --}}
                <li class="nav-item ">
                    <a class="nav-link active" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <svg
                            xmlns="http://www.w3.org/2000/svg" width="25.6" height="25.6" fill="currentColor"
                            class="bi bi-box-arrow-right  mb-0 ml-1" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                  d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                            <path fill-rule="evenodd"
                                  d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                        </svg>
                        {{-- {{ __('Logout') }} --}}
                        <p class="mb-0 ">{{ __('Logout') }}</p>

                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">


                        @csrf


                    </form>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
