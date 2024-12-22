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
                                    <h3 class="display-6 text-center">Selected Member List</h3>
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
                                        <!-- Add Members Button -->
                                        <div class="mt-3 mb-3 mx-3 text-lg-right">
                                            <a href="{{ url('/add-member-to-schedule/' . $examConfiguration->id) }}" class="btn btn-success btn-lg">
                                                <i class="fas fa-plus-circle mr-2"></i> Add Members
                                            </a>
                                        </div>

                                        @if($schedules->isEmpty())
                                            <div class="alert alert-info text-center">
                                                No member added yet.
                                            </div>
                                        @else
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
                                                        <td>{{ $examConfiguration->exam->exam_name ?? 'N/A' }}</td>
                                                        <td>{{ $s->member->name_bn ?? 'N/A' }}</td>
                                                        <td>{{ $s->member->bpid ?? 'N/A' }}</td>
                                                        <td>{{ $s->member->designation_bn ?? 'N/A' }}</td>
                                                        <td>{{ $s->login_time ?? 'N/A' }}</td>
                                                        <td>{{ $s->submission_time ?? 'N/A' }}</td>
                                                        <td>{{ $s->password ?? 'N/A' }}</td>
                                                        <td>{{ $s->status ?? 'N/A' }}</td>
                                                        <td class="text-center">
                                                            @if($s->status == 'completed')
                                                                @if($examConfiguration->exam->type == 'basic_computer_test')
                                                                    <a href="{{ route('basic-computer-test.result', $s->id) }}"
                                                                       class="btn btn-success d-flex align-items-center justify-content-center w-100">
                                                                        <i class="fas fa-check mr-2"></i> View Result
                                                                    </a>
                                                                @elseif($examConfiguration->exam->type == 'mcq')
                                                                    <a href="{{ route('iq-test.result', $s->id) }}"
                                                                       class="btn btn-success d-flex align-items-center justify-content-center w-100">
                                                                        <i class="fas fa-check mr-2"></i> View Result
                                                                    </a>
                                                                @elseif($examConfiguration->exam->type == 'advanced_computer_test')
                                                                    @if($s->is_evaluated == 'yes')
                                                                        <a href="{{ route('examiner.print-exam-result', $s->id) }}"
                                                                           class="btn btn-success d-flex align-items-center justify-content-center w-100">
                                                                            <i class="fas fa-check mr-2"></i> View Result
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
                                                                    class="btn btn-secondary"
                                                                    >
                                                                    <i class="fas fa-times mr-2"></i> Unavailable
                                                                 </span>
                                                            @endif
                                                        </td>
                                                        <td>

                                                            <a href="{{ asset('/delete/schedule/'.$s->id) }}"
                                                               class="btn  btn-danger">
                                                                <i class="fas fa-trash"></i> Remove
                                                            </a>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endsection
@endsection
