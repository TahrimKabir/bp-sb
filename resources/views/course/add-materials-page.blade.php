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
                        <div class="col-12 justify-content-center">
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
                                <div class="card-header clr-dark-green">
                                    <h3 class="text-center display-6 mb-0">
                                        <i class="fas fa-folder-plus mr-2"></i> Add New Course Materials
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.store.materials') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="lesson_id"> Select Lesson</label>
                                            <select class="form-control" name="lesson_id" id="lesson_id">
                                                @foreach ($lessons as $lesson)
                                                    <option value="{{ $lesson->id_lessons }}">{{ $lesson->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- First Material section -->
                                        <div class="card mb-4 shadow-lg p-3 rounded border material-card"
                                             style="background-color: #f9f9f9; border: 2px solid #28a745; border-radius: 10px;">
                                            <div class="card-header bg-secondary text-white">
                                                <h5 class="mb-0"><i class="fas fa-layer-group mr-2"></i> Material 1</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="material_type_0">Material Type</label>
                                                    <select class="form-control material_type" name="materials[0][material_type]" id="material_type_0">
                                                        <option value="pdf">PDF</option>
                                                        <option value="audio">Audio</option>
                                                        <option value="video">Video</option>
                                                        <option value="link">External Link</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="material_name_0"> Material Name (Optional)</label>
                                                    <input type="text" class="form-control" name="materials[0][material_name]" id="material_name_0" placeholder="Enter material name (optional)">
                                                </div>

                                                <div id="material_url_container_0" class="form-group">
                                                    <!-- Input will be dynamically generated -->
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Additional material sections -->
                                        <div id="additional-materials"></div>

                                        <button type="button" class="btn btn-outline-secondary mb-4" id="add-material-btn">
                                            <i class="fas fa-plus-circle mr-2"></i> Add Another Material
                                        </button>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-upload mr-2"></i> Submit Materials
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
            let materialCount = 1;

            // Function to update the file input based on material type
            function updateFileInput(materialTypeSelect, count) {
                let fileInputContainer = $(`#material_url_container_${count}`);
                let materialType = materialTypeSelect.val();

                // Remove existing input field
                fileInputContainer.empty();

                if (materialType === 'pdf') {
                    fileInputContainer.append(`
                        <label for="material_url_${count}"><i class="fas fa-file-pdf mr-2"></i> Upload PDF</label>
                        <input type="file" class="form-control" name="materials[${count}][material_url]" id="material_url_${count}" accept=".pdf">
                    `);
                } else if (materialType === 'audio') {
                    fileInputContainer.append(`
                        <label for="material_url_${count}"><i class="fas fa-file-audio mr-2"></i> Upload Audio</label>
                        <input type="file" class="form-control" name="materials[${count}][material_url]" id="material_url_${count}" accept="audio/*">
                    `);
                } else if (materialType === 'video') {
                    fileInputContainer.append(`
                        <label for="material_url_${count}"><i class="fas fa-file-video mr-2"></i> Upload Video</label>
                        <input type="file" class="form-control" name="materials[${count}][material_url]" id="material_url_${count}" accept="video/*">
                    `);
                } else if (materialType === 'link') {
                    fileInputContainer.append(`
                        <label for="material_url_${count}"><i class="fas fa-link mr-2"></i> Enter External Link</label>
                        <input type="text" class="form-control" name="materials[${count}][material_url]" id="material_url_${count}" placeholder="Enter link here">
                    `);
                }
            }

            // Initial update for the first material
            updateFileInput($('#material_type_0'), 0);

            // Add material handler
            $('#add-material-btn').click(function() {
                materialCount++;

                $('#additional-materials').append(`
                    <div class="card mb-4 shadow-lg p-3 rounded border material-card"
                         >
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0"><i class="fas fa-layer-group mr-2"></i> Material ${materialCount}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="material_type_${materialCount}">Material Type</label>
                                <select class="form-control material_type" name="materials[${materialCount}][material_type]" id="material_type_${materialCount}">
                                    <option value="pdf">PDF</option>
                                    <option value="audio">Audio</option>
                                    <option value="video">Video</option>
                                    <option value="link">External Link</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="material_name_${materialCount}"> Material Name (Optional)</label>
                                <input type="text" class="form-control" name="materials[${materialCount}][material_name]" id="material_name_${materialCount}" placeholder="Enter material name (optional)">
                            </div>
                            <div id="material_url_container_${materialCount}" class="form-group">
                                <!-- Input will be dynamically updated -->
                            </div>
                        </div>
                    </div>
                `);

                // Update the file input for the newly added material
                $(`#material_type_${materialCount}`).on('change', function() {
                    updateFileInput($(this), materialCount);
                });

                // Initialize with the first option (PDF)
                updateFileInput($(`#material_type_${materialCount}`), materialCount);
            });

            // Update input when the material type changes for the first material
            $('#material_type_0').on('change', function() {
                updateFileInput($(this), 0);
            });
        });
    </script>
@endsection
