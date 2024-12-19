@extends('dashboard')
@section('style')
    @include('layouts.dataTable')
    <link rel="stylesheet" href="{{ asset('custom/main.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

@endsection
@section('main')
    @parent

    @section('edit')
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header clr-dark-green">
                                    <h3 class="display-6 text-center">Exam Schedules</h3>
                                </div>
                                <div class="card-body">
                                    <!-- Display Messages -->
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
                                    @if($examConfigurations->isEmpty())
                                        <div class="alert alert-info text-center">
                                            No schedules created yet.
                                        </div>
                                    @else
                                    <!-- Exam Configurations Table -->
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="text-center">SL</th>
                                            <th class="text-center" >Configuration Name</th>

                                            <th class="text-center" >Exam</th>
                                            <th class="text-center">Exam Date</th>
                                            <th class="text-center">Start Time</th>
                                            <th class="text-center">End Time</th>

                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($examConfigurations as $key => $config)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="text-center">{{ $config->name ?? 'Unnamed Configuration' }}</td>

                                                <td class="text-center">{{ $config->exam->exam_name ?? 'N/A' }}</td>
                                                <td class="text-center">{{ $config->date ?? 'N/A' }}</td>
                                                <td class="text-center">{{ $config->start_time ?? 'N/A' }}</td>
                                                <td class="text-center">{{ $config->end_time ?? 'N/A' }}</td>

                                                <td class="text-center">
                                                    <a href="{{ route('schedule.show', $config->id) }}" class="btn btn-primary">
                                                       view selected members
                                                    </a>

                                                    <!-- Edit button, disabled if the start time is not greater than the current time -->
                                                    <a href="{{ url('/edit/schedule/'.$config->id) }}"
                                                       class="btn btn-warning"
                                                       @if (strtotime($config->start_time) <= strtotime(now()))
                                                           disabled
                                                        @endif>
                                                        <i class="bi bi-pencil-square"></i>  Edit
                                                    </a>

                                                    <!-- Delete button, triggers confirmation modal -->
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $config->id }}">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="deleteModal{{ $config->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $config->id }}" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel{{ $config->id }}">Confirm Delete</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete this exam schedule?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                    <form action="{{ route('exam.configuration.destroy', $config->id) }}" method="POST" style="display:inline-block;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
            </section>
        </div>
    @endsection
@endsection
