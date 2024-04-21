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
@endphp

    <!-- Header Illustration -->
<div class="container-fluid bg-primary py-5 mb-5 course{{ $course_id }}">
    <div class="container py-2">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-5 text-white animated slideInDown">{{ $course->title }}</h1>
                <p class="fs-5 text-white mb-4 pb-2">বাংলাদেশ পুলিশ উইমেন নেটওয়ার্ক কর্তৃক আয়োজিত অনলাইন প্রশিক্ষণ</p>
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
            @php
                $course_status = DB::table('members_course_status')->where('member_id', $member->id)->where('course_id', $course_id)->first();

                if ($course_id != 3) {
            @endphp
            <div class="col-lg-3 col-sm-6 wow fadeInUp my-3 {{ $course_status->pre_evalution ? 'pe-none user-select-none' : '' }}" data-wow-delay="0.1s">
                <div class="service-item2 pt-3 border rounded alert-warning h-100">
                    <div class="p-4">
                        <h6 class="text-end">জরিপ</h6>
                        <i class="far fa-lightbulb fa-3x text-{{ $course_status->pre_evalution ? 'success' : 'primary' }} mb-4"></i>
                        <div style="height: 3.6rem;">
                            <h5 class="mb-3">প্রাথমিক জরিপ</h5>
                        </div>
                        <hr>
                        <span class="{{ $course_status->pre_evalution ? 'text-success' : 'text-danger' }}">
                            <i class="{{ $course_status->pre_evalution ? 'fas fa-check-circle' : 'fas fa-circle-notch' }}"></i> {{ $course_status->pre_evalution ? 'সম্পন্ন হয়েছে' : 'অসম্পূর্ণ' }}
                        </span>
                        <div class="d-grid mt-2">
                            <a href="{{ url('member/course/pre-quiz/'. $course_status->course_id) }}" class="btn btn-outline-{{ $course_status->pre_evalution ? 'success' : 'info' }}">{{ $course_status->pre_evalution ? 'সম্পন্ন' : 'শুরু করুন' }}</a>
                        </div>
                    </div>
                </div>
            </div>
            @php
                }

                $lessons = DB::table('lessons')->where('courses_id', $course_id)->orderBy('lesson_no', 'asc')->get();
                $deactive = true;
                $is_complete_course = true;
                if ($course_status->pre_evalution) $deactive = false;
                foreach ($lessons as $lesson) {
            @endphp
            <div class="col-lg-3 col-sm-6 wow fadeInUp my-3 {{ $deactive ? 'pe-none user-select-none' : '' }}" data-wow-delay="0.1s">
                <div class="service-item pt-3 border rounded">
                    <div class="p-4">
                        <h6 class="text-end">পাঠ-{{ \App\Traits\BanglaConverter::en2bn($lesson->lesson_no) }}</h6>
                        <img src="{{asset('/img/lesson_preview/lesson-'. $lesson->id_lessons.'.png')}}" alt="" height="90px" class="py-3">
                        <div style="height: 3.6rem;">
                            <h5 class="mb-3">{!! $lesson->title !!} </h5>
                        </div>
                        <hr>
                        <span class="{{ $course_status->{"lesson_" . $lesson->lesson_no} && !$deactive ? 'text-success' : 'text-danger' }}">

                            <i class="{{ $course_status->{'lesson_' . $lesson->lesson_no} && !$deactive ? 'fas fa-check-circle' : 'fas fa-circle-notch' }}"></i> {{ $course_status->{'lesson_' . $lesson->lesson_no} && !$deactive ? 'সম্পন্ন হয়েছে' : 'অসম্পূর্ণ' }}
                        </span>
                        <div class="d-grid mt-2">
                            <a href="{{url('/member/course/lesson/'.$lesson->id_lessons)}}" class="btn btn-outline-{{ $deactive ? 'secondary' : ($course_status->{'lesson_' . $lesson->lesson_no} ? 'success' : 'primary') }}">
                                @if($deactive)
                                    পূর্ববর্তী পাঠ সম্পন্ন করুন
                                @elseif($course_status->{'lesson_' . $lesson->lesson_no})
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
                if (!$course_status->{'lesson_' . $lesson->lesson_no}) {
                    $deactive = true;
                    $is_complete_course = false;
                }
            }
            @endphp

            <div class="col-lg-3 col-sm-6 wow fadeInUp my-3 {{ $is_complete_course && $course_status->exam == 0 ? '' : 'pe-none user-select-none' }}" data-wow-delay="0.1s">
                <div class="service-item2 pt-3 border rounded alert-danger h-100">
                    <div class="p-4">
                        <h6 class="text-end">কুইজ</h6>
                        <i class="fas fa-file-signature fa-3x text-{{ $is_complete_course ? ($course_status->exam ? 'success' : 'primary') : 'secondary' }} mb-4"></i>
                        <div style="height: 3.6rem;">
                            <h5 class="mb-3">মূল্যায়ন</h5>
                        </div>
                        <hr>
                        <span class="{{ $course_status->exam ? 'text-success' : 'text-danger' }}">
                            <i class="{{ $course_status->exam ? 'fas fa-check-circle' : 'fas fa-circle-notch' }}"></i> {{ $course_status->exam ? 'সম্পন্ন হয়েছে' : 'অসম্পূর্ণ' }}
                        </span>
                        <div class="d-grid mt-2">
                            <a href="{{url('/member/course/quiz/'. $course_status->course_id) }}" class="btn btn-outline-{{ $is_complete_course ? ($course_status->exam ? 'success' : 'primary') : 'secondary' }}">{{ $course_status->exam ? 'সম্পন্ন' : 'শুরু করুন' }}</a>
                        </div>
                    </div>
                </div>
            </div>

            @if ($course_id != 3)
                <div class="col-lg-3 col-sm-6 wow fadeInUp my-3 {{ $course_status->post_evalution || $course_status->exam == 0 ? 'pe-none user-select-none' : '' }}" data-wow-delay="0.1s">
                    <div class="service-item2 pt-3 border rounded alert-warning h-100">
                        <div class="p-4">
                            <h6 class="text-end">জরিপ</h6>
                            <i class="far fa-lightbulb fa-3x text-{{ $course_status->post_evalution ? 'success' : ($course_status->exam ? 'primary' : 'secondary') }} mb-4"></i>
                            <div style="height: 3.6rem;">
                                <h5 class="mb-3">চূড়ান্ত জরিপ</h5>
                            </div>
                            <hr>
                            <span class="{{ $course_status->post_evalution ? 'text-success' : 'text-danger' }}">
                            <i class="{{ $course_status->post_evalution ? 'fas fa-check-circle' : 'fas fa-circle-notch' }}"></i> {{ $course_status->post_evalution ? 'সম্পন্ন হয়েছে' : 'অসম্পূর্ণ' }}
                        </span>
                            <div class="d-grid mt-2">
                                <a href="{{url('/post-quiz/'.$course_status->course_id)}}" class="btn btn-outline-{{ $course_status->post_evalution ? 'success' : ($course_status->exam ? 'primary' : 'secondary') }}">{{ $course_status->post_evalution ? 'সম্পন্ন' : 'শুরু করুন' }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Service End -->

@include('course.member_footer')
