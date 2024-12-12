@extends('dashboard')
@section('style')
    @include('layouts.dataTable')
    <link rel="stylesheet" href="{{ asset('custom/main.css') }}">
    <style>
        .course-table {
            margin-bottom: 30px;
        }
        .course-table th {
            text-align: center;
        }
        .course-table td {
            text-align: center;
        }

        .no-materials-message {
            text-align: center;
            color: red;
            font-size: 1.2em;
        }

        .lesson-card {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ccc; /* Lighter border color */
            border-radius: 10px;
            background-color: #f9f9f9; /* Light gray background for the cards */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .course-title-heading {
            background-color: #e0f7fa; /* Light cyan background for a soothing look */
            color: #00796b; /* Teal color for text to create contrast */
            padding: 15px 20px;
            text-align: center;
            border-radius: 8px;
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .lesson-title {
            background-color: #ffffff; /* White background for the lesson titles */
            padding: 10px;
            font-size: 1.2em;
            font-weight: bold;
            border: 1px solid #ddd; /* Subtle border for the titles */
            margin-top: 20px;
            color: #00796b; /* Dark gray text for better readability */
        }
    </style>
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
            <section class="content">
                <div class="container-fluid">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
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
                                    <h3 class="display-6 text-center">Course Materials</h3>
                                </div>

                                <div class="card-body">


                                    <!-- Separate Tables for Each Course -->
                                    @php $noMaterialsFound = true; @endphp  <!-- Flag to check if any material is found -->
                                    @foreach($courses as $course)
                                        @if(($course->id_courses == $selectedCourseId || $selectedCourseId == '') && $course->lessons->pluck('materials')->flatten()->isNotEmpty())
                                            @php $noMaterialsFound = false; @endphp  <!-- Set flag to false if materials are found -->
                                            <div class="course-table">
                                                <h4 class="text-center course-title-heading">{{ $course->title }}</h4>

                                                @foreach($course->lessons as $lesson)
                                                    @if($lesson->materials->isNotEmpty() && ($selectedLessonId == '' || $lesson->id_lessons == $selectedLessonId))
                                                        <div class="lesson-card">
                                                            <div class="lesson-title text-center ">
                                                                {{ $lesson->title }}
                                                            </div>
                                                            <div class="mt-3 mb-3 mx-3 text-lg-right">
                                                                <a href="{{url('admin/add-materials/'.$lesson->id_lessons)}}" class="btn btn-success btn-xs">
                                                                    <i class="fas fa-plus-circle mr-2"></i> Add Material
                                                                </a>
                                                            </div>
                                                            <table class="table table-bordered table-striped">
                                                                <thead>
                                                                <tr>
                                                                    <th>Material Name</th>
                                                                    <th>Material Type</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($lesson->materials as $material)
                                                                    <tr>
                                                                        <td>{{ $material->material_name }}</td>
                                                                        <td>{{ ucfirst($material->material_type) }}</td>
                                                                        <td>
                                                                            <button class="btn btn-sm btn-info"
                                                                                    data-toggle="modal"
                                                                                    data-target="#viewMaterialModal"
                                                                                    data-name="{{ $material->material_name }}"
                                                                                    data-type="{{ ucfirst($material->material_type) }}"
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
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    @endforeach

                                    <!-- Show No Materials Found Message -->
                                    @if($noMaterialsFound)
                                        <div class="no-materials-message">
                                            No materials found .
                                        </div>
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
