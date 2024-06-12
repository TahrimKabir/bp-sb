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
        {{--        Course and quiz navigation start--}}

        <div class="d-flex justify-content-around">
            <div class="col-lg-5 col-sm-6 wow fadeInUp my-3 " data-wow-delay="0.1s">
                <div class="service-item pt-3 border rounded">
                    <div class="p-4">

                        <img src="{{asset('img/lesson_preview/lesson-13.png')}}" height="90px" class="py-2"/>
                        <div style="height: 3.6rem;">
                            <h5 class="mb-3">কোর্স ম্যাটেরিয়াল</h5>

                        </div>

                        <hr>

                        <div class="d-grid mt-2">
                            <button class="btn btn-outline-primary" id="see-course-btn" data-toggle="modal"
                                    data-target="#courseModal">পড়ুন
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{--            Quiz button start--}}
            <div class="col-lg-5 col-sm-6 wow fadeInUp my-3 " data-wow-delay="0.1s">
                <div class="service-item pt-3 border ">
                    <div class="p-4">
                        <i class="fas fa-file-signature fa-3x  mb-4"></i>
                        <div style="height: 3.6rem;">
                            <h5 class="mb-3">কুইজ </h5>

                        </div>

                        <hr>
                        <div class="d-grid mt-2">
                            <a href="{{url('/member/course/quiz/'.$lesson->id_lessons) }}" class="btn btn-outline-primary">কুইজে
                                অংশ নিন </a>
                        </div>

                    </div>
                </div>
            </div>
            {{--            Quiz button end--}}

        </div>

        {{--        Course and quiz navigation end--}}


        <!-- Modal -->
        <div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="courseModalLabel">কোর্স ম্যাটেরিয়াল</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="pdf-preview">
                            <iframe id="pdf-frame" src="" width="100%" height="700" style="border: none;" frameborder="0"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="d-flex justify-content-between">
            @if($lesson->id_lessons!=1)
                <a href="{{url('/member/course/lesson/'.$lesson->id_lessons-1)}}"
                   class="btn btn-outline-primary rounded-pill"><i class="fas fa-arrow-left"></i> পূর্ববর্তী </a>
            @endif
            <a href="{{ url('/member/course/lesson/'.$lesson->id_lessons+1) }}"
               class="btn btn-outline-primary rounded-pill">পরবর্তী <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</div>

@include('course.member_footer')

<script>
    document.getElementById('see-course-btn').addEventListener('click', function() {
        var lessonId = '{{ $lesson->id_lessons }}';

        var pdfSrc = '{{ asset("course-files/lesson_" . $lesson->id_lessons . ".pdf") }}';
        document.getElementById('pdf-frame').src = pdfSrc;
    });
</script>
