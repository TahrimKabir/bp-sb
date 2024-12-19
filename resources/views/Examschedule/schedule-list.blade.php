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
                                    <table id="example1" class="table table-bordered table-striped"
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
