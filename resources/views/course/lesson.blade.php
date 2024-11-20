<!-- Course 1 Chapter 1 -->
@include('course.member_header')

<!-- Bootstrap CSS -->

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div class="container-xxl py-4 mb-5">
    <div class="container">
        <a href="{{ url('/member/course-details/'.$lesson->courses_id) }}"><i class="fas fa-arrow-left"></i> কোর্সে ফিরে যান </a>
        <br><br>
        <h5>পাঠ-{{ App\Traits\BanglaConverter::en2bn($lesson->lesson_no) }}</h5>

        <hr>
        <br>

        <!-- Display Course Materials by Category -->
        <div class="row">

            <!-- PDFs Section -->
            <div class="col-12 mb-5 p-4" style="border: 1px solid #ddd; background-color: #f9f9f9; border-radius: 8px;">
                <h4 class="category-heading text-primary mb-4"><i class="fas fa-file-pdf"></i> PDFs</h4>
                <div class="row">
                    @if($lesson->materials->where('material_type', 'pdf')->isEmpty())
                        <div class="col-12">
                            <p class="text-muted">No PDFs available for this lesson.</p>
                        </div>
                    @else
                        @foreach($lesson->materials->where('material_type', 'pdf') as $material)
                            <div class="col-lg-5 col-sm-6 wow fadeInUp my-3" data-wow-delay="0.1s">
                                <div class="service-item pt-3 border rounded">
                                    <div class="p-4">
                                        <img src="{{asset('assets/image/pdf.png')}}" height="90px" class="py-2" />
                                        <h5 class="mb-3">{{ $material->material_name }}</h5>
                                        <hr>
                                        <div class="d-grid mt-2">
                                            <button class="btn btn-outline-primary" data-toggle="modal" data-target="#materialModal" onclick="viewMaterial('{{ asset('storage/' . $material->material_url) }}', 'pdf')">পড়ুন</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Videos Section -->
            <div class="col-12 mb-5 p-4" style="border: 1px solid #ddd; background-color: #eef6ff; border-radius: 8px;">
                <h4 class="category-heading text-success mb-4"><i class="fas fa-video"></i> Videos</h4>
                <div class="row">
                    @if($lesson->materials->where('material_type', 'video')->isEmpty())
                        <div class="col-12">
                            <p class="text-muted">No videos available for this lesson.</p>
                        </div>
                    @else
                        @foreach($lesson->materials->where('material_type', 'video') as $material)
                            <div class="col-lg-5 col-sm-6 wow fadeInUp my-3" data-wow-delay="0.1s">
                                <div class="service-item pt-3 border rounded">
                                    <div class="p-4">
                                        <img src="{{asset('assets/image/video.png')}}" height="90px" class="py-2" />
                                        <h5 class="mb-3">{{ $material->material_name }}</h5>
                                        <hr>
                                        <div class="d-grid mt-2">
                                            <button class="btn btn-outline-primary" data-toggle="modal" data-target="#materialModal" onclick="viewMaterial('{{ asset('storage/' . $material->material_url) }}', 'video')">ভিডিও দেখুন</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Audios Section -->
            <div class="col-12 mb-5 p-4" style="border: 1px solid #ddd; background-color: #fff7e5; border-radius: 8px;">
                <h4 class="category-heading text-warning mb-4"><i class="fas fa-headphones"></i> Audios</h4>
                <div class="row">
                    @if($lesson->materials->where('material_type', 'audio')->isEmpty())
                        <div class="col-12">
                            <p class="text-muted">No audios available for this lesson.</p>
                        </div>
                    @else
                        @foreach($lesson->materials->where('material_type', 'audio') as $material)
                            <div class="col-lg-5 col-sm-6 wow fadeInUp my-3" data-wow-delay="0.1s">
                                <div class="service-item pt-3 border rounded">
                                    <div class="p-4">
                                        <img src="{{asset('assets/image/sound.png')}}" height="90px" class="py-2" />
                                        <h5 class="mb-3">{{ $material->material_name }}</h5>
                                        <hr>
                                        <div class="d-grid mt-2">
                                            <button class="btn btn-outline-primary" data-toggle="modal" data-target="#materialModal" onclick="viewMaterial('{{ asset('storage/' . $material->material_url) }}', 'audio')">অডিও শুনুন</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Links Section -->
            <div class="col-12 mb-5 p-4" style="border: 1px solid #ddd; background-color: #e5f5ff; border-radius: 8px;">
                <h4 class="category-heading text-info mb-4"><i class="fas fa-link"></i> Links</h4>
                <div class="row">
                    @if($lesson->materials->where('material_type', 'link')->isEmpty())
                        <div class="col-12">
                            <p class="text-muted">No links available for this lesson.</p>
                        </div>
                    @else
                        @foreach($lesson->materials->where('material_type', 'link') as $material)
                            <div class="col-lg-5 col-sm-6 wow fadeInUp my-3" data-wow-delay="0.1s">
                                <div class="service-item pt-3 border rounded">
                                    <div class="p-4">
                                        <img src="{{asset('assets/image/link.png')}}" height="90px" class="py-2" />
                                        <h5 class="mb-3">{{ $material->material_name }}</h5>
                                        <hr>
                                        <div class="d-grid mt-2">
                                            <button class="btn btn-outline-primary" data-toggle="modal" data-target="#materialModal" onclick="viewMaterial('{{ $material->material_url }}', 'link')">লিঙ্কে যান</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>

        <!-- Check for quiz questions availability -->
        @php
            $quizAvailable = DB::table('quiz_questions')->where('lesson_id', $lesson->id_lessons)->exists();
        @endphp

            <!-- Quiz Section -->
        <div class="quiz-section mt-5" style="border: 1px solid #ddd; border-radius: 8px; padding: 20px; height: 200px;
    background-color: {{ $quizAvailable ? '#e0f7fa' : '#f8d7da' }}; display: flex; flex-direction: column; justify-content: center; align-items: center;">
            <h4 class="text-primary mb-4"><i class="fas fa-question-circle"></i> কুইজ</h4>
            @if($quizAvailable)
                <a href="{{ url('/member/course/quiz/'.$lesson->id_lessons) }}" class="btn btn-success" style="padding: 20px 30px;border-radius: 8px;">কুইজে অংশ নিন <i class="fas fa-play-circle"></i></a>
            @else
                <p class="text-danger mb-0">কুইজ প্রশ্ন অনুপস্থিত</p>
            @endif
        </div>

        <!-- Lesson Navigation -->
        <div class="d-flex justify-content-between mt-5">
            @if($lesson->id_lessons != 1)
                <a href="{{ url('/member/course/lesson/' . ($lesson->id_lessons - 1)) }}" class="btn btn-outline-primary rounded-pill">
                    <i class="fas fa-arrow-left"></i> পূর্ববর্তী
                </a>
            @endif
            <a href="{{ url('/member/course/lesson/' . ($lesson->id_lessons + 1)) }}" class="btn btn-outline-primary rounded-pill">
                পরবর্তী <i class="fas fa-arrow-right"></i>
            </a>
        </div>

    </div>
</div>

        <!-- Modal for viewing material -->
        <div class="modal fade" id="materialModal" tabindex="-1" aria-labelledby="materialModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="materialModalLabel">Material Viewer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modalBodyContent">
                        <!-- Dynamic content will be loaded here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript to load material content into modal -->
        <script>
            function viewMaterial(url, type) {
                let modalBodyContent = document.getElementById('modalBodyContent');

                if (type === 'pdf') {
                    modalBodyContent.innerHTML = `<embed src="${url}" width="100%" height="500px" type="application/pdf">`;
                } else if (type === 'video') {
                    modalBodyContent.innerHTML = `<video width="100%" height="auto" controls><source src="${url}" type="video/mp4">Your browser does not support the video tag.</video>`;
                } else if (type === 'audio') {
                    modalBodyContent.innerHTML = `<audio controls><source src="${url}" type="audio/mp3">Your browser does not support the audio tag.</audio>`;
                } else if (type === 'link') {
                    // Check if the link is a YouTube URL
                    const youtubeRegex = /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|embed)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
                    const match = url.match(youtubeRegex);

                    if (match && match[1]) {
                        // If it's a YouTube URL, embed the video
                        const videoId = match[1];
                        modalBodyContent.innerHTML = `<iframe width="100%" height="500px" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
                    } else {
                        // If not a YouTube URL, just show the link
                        modalBodyContent.innerHTML = `<a href="${url}" target="_blank">${url}</a>`;
                    }
                }
            }

        </script>

    </div>
</div>
