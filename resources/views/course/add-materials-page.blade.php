@extends('dashboard')
@section('main')
    @parent

    <!-- Content Wrapper. Contains page content -->
    @section('edit')
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content p-4">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
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
                                <div class="card-header text-white bg-dark">
                                    <h4 class="text-center mb-0">
                                        <i class="fas fa-folder-plus mr-2"></i> Add Course Material
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.store.materials') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="lesson_id">Lesson</label>
                                            <input type="text" class="form-control" id="lesson_id_display" value="{{ $lesson->title }}" disabled>
                                            <input type="hidden" name="lesson_id" id="lesson_id" value="{{ $lesson->id_lessons }}">
                                        </div>

                                        <!-- Material section -->
                                        <div class="card shadow-sm mb-3">
                                            <div class="card-header clr-dark-green text-white">
                                                <h5 class="mb-0"><i class="fas fa-layer-group mr-2"></i> Material</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="material_type">Material Type</label>
                                                    <select class="form-control material_type" name="material_type" id="material_type">
                                                        <option value="pdf">PDF</option>
                                                        <option value="audio">Audio</option>
                                                        <option value="video">Video</option>
                                                        <option value="link">External Link</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="material_name">Material Name (Optional)</label>
                                                    <input type="text" class="form-control" name="material_name" id="material_name" placeholder="Enter material name (optional)">
                                                </div>

                                                <div id="material_url_container" class="form-group">
                                                    <!-- Input will be dynamically updated -->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group text-center">
                                            <button type="submit" class="btn clr-dark-green">
                                                <i class="fas fa-upload mr-2"></i> Submit Material
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
    @endsection

@endsection

@section('script')
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- FontAwesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <script>
        $(document).ready(function() {
            // Function to update the file input based on material type
            function updateFileInput(materialTypeSelect) {
                let fileInputContainer = $('#material_url_container');
                let materialType = materialTypeSelect.val();

                // Remove existing input field
                fileInputContainer.empty();

                if (materialType === 'pdf') {
                    fileInputContainer.append(`
                        <label for="material_url"><i class="fas fa-file-pdf mr-2"></i> Upload PDF</label>
                        <input type="file" class="form-control" name="material_url" id="material_url" accept=".pdf">
                    `);
                } else if (materialType === 'audio') {
                    fileInputContainer.append(`
                        <label for="material_url"><i class="fas fa-file-audio mr-2"></i> Upload Audio</label>
                        <input type="file" class="form-control" name="material_url" id="material_url" accept="audio/*">
                    `);
                } else if (materialType === 'video') {
                    fileInputContainer.append(`
                        <label for="material_url"><i class="fas fa-file-video mr-2"></i> Upload Video</label>
                        <input type="file" class="form-control" name="material_url" id="material_url" accept="video/*">
                    `);
                } else if (materialType === 'link') {
                    fileInputContainer.append(`
                        <label for="material_url"><i class="fas fa-link mr-2"></i> Enter External Link</label>
                        <input type="text" class="form-control" name="material_url" id="material_url" placeholder="Enter link here">
                    `);
                }
            }

            // Initial update for the material input
            updateFileInput($('#material_type'));

            // Update input when the material type changes
            $('#material_type').on('change', function() {
                updateFileInput($(this));
            });
        });
    </script>
@endsection
