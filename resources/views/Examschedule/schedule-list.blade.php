@extends('dashboard')

@section('main')
    @parent

    @section('edit')
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center mt-4">
                        <div class="col-12 justify-content-center">
                            <div class="card">
                                <div class="card-header clr-dark-green">
                                    <h3 class="display-6 text-center">Schedule List</h3>
                                </div>
                                <div class="card-body">
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
                                    <div class="card-body">
                                        <!-- Filter Form -->
                                        <form method="GET" action="{{ route('schedule.index') }}" class="mb-4">
                                            <div class="form-group row">
                                                <label for="exam_config_id" class="col-sm-2 col-form-label">Select Exam
                                                    Configuration:</label>
                                                <div class="col-sm-8">
                                                    <select name="exam_config_id" id="exam_config_id"
                                                            class="form-control">
                                                        <option value="">-- Select Configuration --</option>
                                                        @foreach ($examConfigurations as $config)
                                                            <option value="{{ $config->id }}"
                                                                {{ $selectedConfigId == $config->id ? 'selected' : '' }}>
                                                                {{ $config->name ?? 'Unnamed Configuration' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="submit" class="btn btn-primary">Filter</button>
                                                </div>
                                            </div>
                                        </form>

                                        <!-- Display Schedules -->
                                        @if ($selectedConfigId && $schedule->isEmpty())

                                            <div class="alert alert-danger  text-lg-center" style="font-size: 24px">
                                                No schedule found for the selected configuration.
                                            </div>
                                            <div class="mt-3 mb-3 mx-3 text-lg-center">
                                                <a href="{{ url('/add-member-to-schedule/' . $selectedConfigId) }}"
                                                   class="btn btn-success btn-lg">
                                                    <i class="fas fa-plus-circle mr-2"></i> Add members
                                                </a>
                                            </div>
                                        @elseif ($selectedConfigId)

                                            <div class="mt-3 mb-3 mx-3 text-lg-right">
                                                <a href="{{ url('/add-member-to-schedule/' . $selectedConfigId) }}"
                                                   class="btn btn-success btn-lg">
                                                    <i class="fas fa-plus-circle mr-2"></i> Add members
                                                </a>
                                            </div>
                                            @foreach ($schedule as $configId => $schedules)
                                                <h3 class="text-center p-3 rounded shadow-sm"
                                                    style="background-color: #e8f5e9; color: #2e7d32; font-family: 'Arial', sans-serif; border: 2px solid #a5d6a7;">
                                                    Exam
                                                    Configuration: {{ $schedules->first()->config->name ?? 'Unnamed Configuration' }}
                                                </h3>
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>SL</th>
                                                        <th>Exam</th>
                                                        <th>Selected Police</th>
                                                        <th>Police Id</th>
                                                        <th>Post</th>
                                                        <th>Login Time</th>
                                                        <th>Submission Time</th>
                                                        <th>Exam Pin</th>
                                                        <th>Status</th>
                                                        <th>Result</th>
                                                        <th>Remove</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($schedules as $key => $s)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $s->config->exam->exam_name ?? 'N/A' }}</td>
                                                            <td>{{ $s->member->name_bn ?? 'N/A' }}</td>
                                                            <td>{{ $s->member->bpid ?? 'N/A' }}</td>
                                                            <td>{{ $s->member->designation_bn ?? 'N/A' }}</td>
                                                            <td>{{ $s->login_time ?? 'N/A' }}</td>
                                                            <td>{{ $s->submission_time ?? 'N/A' }}</td>
                                                            <td>{{ $s->password ?? 'N/A' }}</td>
                                                            <td>{{ $s->status ?? 'N/A' }}</td>
                                                            <td class="text-center">
                                                                @if($s->status == 'completed')
                                                                    @if($s->config->exam->type == 'basic_computer_test')
                                                                        <a href="{{ route('basic-computer-test.result', $s->id) }}"
                                                                           class="btn btn-success d-flex align-items-center justify-content-center w-100">
                                                                            <i class="fas fa-check mr-2"></i> View
                                                                            Result
                                                                        </a>
                                                                    @elseif($s->config->exam->type == 'mcq')
                                                                        <a href="{{ route('iq-test.result', $s->id) }}"
                                                                           class="btn btn-success d-flex align-items-center justify-content-center w-100">
                                                                            <i class="fas fa-check mr-2"></i> View
                                                                            Result
                                                                        </a>
                                                                    @elseif($s->config->exam->type == 'advanced_computer_test')
                                                                        @if($s->is_evaluated == 'yes')
                                                                            <a href="{{ route('examiner.print-exam-result', $s->id) }}"
                                                                               class="btn btn-success d-flex align-items-center justify-content-center w-100">
                                                                                <i class="fas fa-check mr-2"></i> View
                                                                                Result
                                                                            </a>
                                                                        @else
                                                                            <span
                                                                                class="badge badge-warning d-flex align-items-center justify-content-center w-100 p-2"
                                                                                style="font-size: 16px;">
                    <i class="fas fa-hourglass-half mr-2"></i> Evaluation Pending
                </span>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    <span
                                                                        class="badge badge-secondary d-flex align-items-center justify-content-center w-100 p-2"
                                                                        style="font-size: 16px;">
            <i class="fas fa-times mr-2"></i> Unavailable
        </span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="{{ asset('/delete/schedule/'.$s->id) }}"
                                                                   class="btn btn-xs btn-danger">
                                                                    <i class="fas fa-trash"></i> Remove
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        </div>
    @endsection
@endsection
