@extends('dashboard')
@section('main')
    @parent

    @section('edit')
        <div class="content-wrapper">
            <section class="content p-4">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="card">
                                <div id="message-container">
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
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
                                <div class=" card-header clr-dark-green">
                                    <h3 class="text-center display-6 mb-0">Add New Lesson</h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('lessons.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="courses_id"> Select Course</label>
                                            <select class="form-control" name="courses_id" id="courses_id">
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->id_courses }}">{{ $course->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="title">Lesson Title:</label>
                                            <input type="text" id="title" name="title" class="form-control" required>
                                        </div>


                                        <button type="submit" class="btn btn-primary">Add Lesson</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endsection
@endsection
