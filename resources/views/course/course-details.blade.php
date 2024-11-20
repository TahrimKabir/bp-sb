@include('course.member_header')

@php
    use Illuminate\Support\Facades\DB;

    if (isset($course) && $course->id_courses > 0) {
        $course_id = (int) $course->id_courses;
        $target_trainee = explode(",", $course->target_trainee);

        if (empty($course) || !in_array($member['post'], $target_trainee)) {
            return redirect()->intended('/member/homepage/');
        }
    } else {
        return redirect()->intended('/member/homepage/');
    }

    // Fetch all lessons in this course
    $lessons = DB::table('lessons')->where('courses_id', $course_id)->orderBy('lesson_no', 'asc')->get();

    // Fetch the member's lesson statuses for this course
    $lesson_statuses = DB::table('member_lesson_status')
        ->where('member_id', $member->id)
        ->where('course_id', $course_id)
        ->pluck('status', 'lesson_id')
        ->toArray();

    $deactive = false; // Start with the first lesson active
@endphp

    <!-- Header Illustration -->
<div class="container-fluid bg-primary py-5 mb-5 ">
    <div class="container py-2">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-5 text-white animated slideInDown">{{ $course->title }}</h1>
            </div>
        </div>
    </div>
</div>
<!-- End of Header Illustration -->

<!-- Service Start -->
<div class="container-xxl mb-5">
    <div class="container">
        <div class="mb-3"><a href="{{ url('member/homepage') }}"><i class="fas fa-arrow-left"></i> ড্যাশবোর্ডে ফিরে চলুন </a></div>
        <div class="row">
            @foreach ($lessons as $index => $lesson)
                @php
                    // Check if the current lesson is marked as completed
                    $lessonCompleted = isset($lesson_statuses[$lesson->id_lessons]) && $lesson_statuses[$lesson->id_lessons] === 'completed';

                    // If the previous lesson was completed, the current one should be active
                    $isActive = !$deactive;

                    // Set deactivation for the next iteration based on current completion status
                    if (!$lessonCompleted) {
                        $deactive = true; // Disable future lessons
                    }
                @endphp
                <div class="col-lg-3 col-sm-6 wow fadeInUp my-3 {{ !$isActive ? 'pe-none user-select-none' : '' }}" data-wow-delay="0.1s">
                    <div class="service-item pt-3 border rounded">
                        <div class="p-4">
                            <h6 class="text-end">পাঠ-{{ \App\Traits\BanglaConverter::en2bn($lesson->lesson_no) }}</h6>
                            <div style="height: 3.6rem;">
                                <h5 class="mb-3">{!! $lesson->title !!} </h5>
                            </div>
                            <hr>
                            <span class="{{ $lessonCompleted ? 'text-success' : 'text-danger' }}">
                                <i class="{{ $lessonCompleted ? 'fas fa-check-circle' : 'fas fa-circle-notch' }}"></i>
                                {{ $lessonCompleted ? 'সম্পন্ন হয়েছে' : 'অসম্পূর্ণ' }}
                            </span>
                            <div class="d-grid mt-2">
                                <a href="{{ url('/member/course/lesson/' . $lesson->id_lessons) }}" class="btn btn-outline-{{ !$isActive ? 'secondary' : ($lessonCompleted ? 'success' : 'primary') }}">
                                    @if(!$isActive)
                                        পূর্ববর্তী পাঠ সম্পন্ন করুন
                                    @elseif($lessonCompleted)
                                        পুনরায় পঠন
                                    @else
                                        শুরু করুন
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    // After processing each lesson, ensure the next lesson's activation is based on this lesson's completion
                    if ($lessonCompleted) {
                        $deactive = false; // Allow the next lesson to be active
                    }
                @endphp
            @endforeach
        </div>
    </div>
</div>
<!-- Service End -->

@include('course.member_footer')
