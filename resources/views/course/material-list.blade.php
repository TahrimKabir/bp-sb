@extends('dashboard')
@section('style')
    @include('layouts.dataTable')
    <link rel="stylesheet" href="{{ asset('custom/main.css') }}">
@endsection

@section('main')
    @parent

    <!-- Content Wrapper -->
    @section('edit')
        <div class="content-wrapper">
{{--/// view modal--}}
            <div class="modal fade" id="viewMaterialModal" tabindex="-1" role="dialog" aria-labelledby="viewMaterialModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewMaterialModalLabel">Material Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="materialContent">
                                <!-- Dynamic content will be loaded here -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
{{--Delete modal--}}

            <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this material?
                        </div>
                        <div class="modal-footer">
                            <form id="deleteMaterialForm" method="POST" action="">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Main Content -->
            <section class="content">
                <div class="container-fluid">

                    @if(session('success'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="row justify-content-center mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header clr-dark-green">
                                    <h3 class="display-6 text-center">Materials List Grouped by Lesson</h3>
                                </div>

                                <div class="card-body">

                                    <!-- Filter Form -->

                                    <form method="GET" action="{{ route('admin.materials') }}">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="lesson_filter" class="form-label">Filter by Lesson:</label>
                                                <select id="lesson_filter" name="lesson_filter" class="form-control">
                                                    <option value="">All Lessons</option>
                                                    @foreach($lessons as $lesson)
                                                        <option value="{{ $lesson->id_lessons }}"
                                                            {{ $selectedLessonId == $lesson->id_lessons ? 'selected' : '' }}>
                                                            {{ $lesson->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 d-flex align-items-end">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-filter"></i> Filter
                                                </button>
                                            </div>
                                        </div>
                                    </form>



                                    <!-- Lessons Accordion -->
                                    <div class="accordion" id="lessonAccordion">
                                        @if($materials != null)
                                            @foreach($materials as $lesson)
                                                <div class="card">
                                                    <div class="card-header" id="heading{{ $lesson->id_lessons }}">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                                    data-target="#collapse{{ $lesson->id_lessons }}" aria-expanded="false"
                                                                    aria-controls="collapse{{ $lesson->id_lessons }}">
                                                                Lesson: {{ $lesson->title }}
                                                            </button>
                                                        </h5>
                                                    </div>

                                                    <div id="collapse{{ $lesson->id_lessons }}" class="collapse"
                                                         aria-labelledby="heading{{ $lesson->id_lessons }}"
                                                         data-parent="#lessonAccordion">
                                                        <div class="card-body">
                                                            @if($lesson->materials->count() > 0)
                                                                <table class="table table-bordered table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>SL No.</th>
                                                                        <th>Material Name</th>
                                                                        <th>Material Type</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($lesson->materials as $material)
                                                                        <tr>
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>{{ $material->material_name }}</td>
                                                                            <td>{{ ucfirst($material->material_type) }}</td>
                                                                            <td>
                                                                                <button
                                                                                    class="btn btn-sm btn-info"
                                                                                    data-toggle="modal"
                                                                                    data-target="#viewMaterialModal"
                                                                                    data-name="{{ $material->material_name }}"
                                                                                    data-type="{{ ucfirst($material->material_type) }}"
                                                                                    {{-- data-url="{{ storage_path('app/public/' . $material->material_url) }}"> --}}
                                                                                    data-url="{{ route('get.storage.file', ['filename' => $material->material_url]) }}">
                                                                                    View
                                                                                </button>
                                                                                <a href="#"
                                                                                   class="btn btn-sm btn-danger"
                                                                                   data-toggle="modal"
                                                                                   data-target="#deleteConfirmationModal"
                                                                                   data-url="{{ route('admin.materials.destroy', $material->material_id) }}">
                                                                                    Delete
                                                                                </a>

                                                                            </td>

                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            @else
                                                                <p>No materials available for this lesson.</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>No lessons available.</p>
                                        @endif
                                    </div>


                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
    @endsection
@endsection

@section('script')
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            // Only one collapse open at a time
            $('#lessonAccordion .collapse').on('show.bs.collapse', function () {
                $('#lessonAccordion .collapse.show').collapse('hide');
            });

            // Handle modal content
            $('#viewMaterialModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var name = button.data('name'); // Extract info from data-* attributes
                var type = button.data('type');
                var url = button.data('url');

                // Dynamically update the modal content
                var modal = $(this);
                modal.find('.modal-title').text('Material: ' + name);

                // Show content based on material type
                var contentHtml = '';
                if (type === 'Pdf') {
                    contentHtml = '<iframe src="' + url + '" frameborder="0" style="width:100%;height:500px;"></iframe>';
                } else if (type === 'Audio') {
                    contentHtml = '<audio controls style="width:100%;"><source src="' + url + '" type="audio/mpeg">Your browser does not support the audio element.</audio>';
                } else if (type === 'Video') {
                    contentHtml = '<video controls style="width:100%;"><source src="' + url + '" type="video/mp4">Your browser does not support the video element.</video>';
                } else if (type === 'Link') {
                    // Detect if the link is a video (YouTube or similar)
                    if (url.includes('youtube.com') || url.includes('youtu.be')) {
                        // Extract the YouTube video ID
                        var videoId = url.includes('youtube.com')
                            ? new URL(url).searchParams.get('v')
                            : url.split('/').pop();

                        contentHtml = `
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item"
                                src="https://www.youtube.com/embed/${videoId}"
                                frameborder="0" allowfullscreen>
                            </iframe>
                        </div>`;
                    } else {
                        // Default for other external links
                        contentHtml = '<a href="' + url + '" target="_blank" class="btn btn-primary">Open Link</a>';
                    }
                }

                modal.find('#materialContent').html(contentHtml);
            });

            // Handle delete confirmation modal
            $('#deleteConfirmationModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var url = button.data('url'); // Extract the delete URL from data-* attribute

                // Update the form action in the modal
                var form = $(this).find('#deleteMaterialForm');
                form.attr('action', url);
            });
        });
    </script>

@endsection
