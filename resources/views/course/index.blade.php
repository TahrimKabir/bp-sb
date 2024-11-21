@include('course.member_header');

<!-- Service Start -->
<div class="container-xxl py-4">
    <div class="container w-100">

        <!-- If there are no courses -->
        @if ($courses->isEmpty())
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="alert alert-warning p-5">
                        <h4 class="alert-heading">No Courses Assigned!</h4>
                        <p class="mb-0">
                            You have not been assigned any courses yet. Please check back later or contact the administrator for more information.
                        </p>
                    </div>
                </div>
            </div>
        @else
            <!-- Courses List -->
            <div class="row d-flex justify-content-center my-5">
                @foreach($courses as $course)
                    <div class="col-lg-4 col-sm-6 wow fadeInUp mt-3" data-wow-delay="0.3s">
                        <div class="service-item text-center border">
                            <div class="p-4">
                                <h5 class="p-4">{{ $course->title }}</h5>
                                <div class="progress">
                                    <div class="progress-bar bg-{{ $course->percent >= 100 ? 'success' : 'primary' }}" style="width:{{ $course->percent }}%"></div>
                                </div>
                                <div class="d-grid mt-2">
                                    @if($course->id_courses == 1)
                                        <a href="{{ url('/member/course-details/'. $course->id_courses) }}" class="text-dark btn btn-outline-{{ $course->percent >= 100 ? 'success' : 'primary' }}">
                                            {{ $course->percent >= 100 ? 'পুনরায় পঠন' : 'শুরু করুন' }}
                                        </a>
                                    @else
                                        <a href="#" class="text-dark btn btn-outline-primary disabled">অনুপস্থিত</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
<!-- Service End -->

@include('course.member_footer');
