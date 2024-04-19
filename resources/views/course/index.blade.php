
@include('course.member_header');

<!-- Service Start -->
<div class="container-xxl py-4">
    <div class="container">
        <!-- progress -->
        <div class="card">
            <div class="card-body bg-light ">
                <div class="row">
                    <div class="col-md-6 text-start mb-2 mb-md-0">
                        <strong>আমার কোর্সের স্ট্যাটাস</strong>
                    </div>
                    <div class="col-md-6 text-end">

                        <strong>{{ App\Traits\BanglaConverter::en2bn(count($courses)) }} </strong> টির মধ্যে <strong>{{ App\Traits\BanglaConverter::en2bn(count($completed_course)) }}</strong> টি কোর্স সম্পন্ন হয়েছে
                    </div>
                </div>
            </div>
        </div>
        <br>
        <!-- my certificates -->
        <div class="card">
            <div class="card-body bg-light">
                <div class="row">
                    <div class="col-md-6 text-start mb-3 mb-md-0">
                        <strong>
                            <img src="{{asset('images/certificate_logo.svg')}}" alt=""> আমার সার্টিফিকেট
                        </strong>
                    </div>
                    <div class="col-md-6 text-end">
                        <a class="btn btn-success" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fas fa-eye"></i> সার্টিফিকেট দেখুন
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card collapse" id="collapseExample">
            <div class="card-body">
                @foreach ($completed_course as $cc)
                    @foreach ($courses as $course)
                        @if ($cc->course_id == $course->id_courses)
                            <div class="card card-body">
                                <a href="certificate.php?course_id={{ $course->id_courses }}">
                                    <i class="fas fa-file-alt"></i> <i class="text-success">"{{ $course->title }}"</i> কোর্সের সার্টিফিকেট ডাউনলোড
                                </a>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>

        <div class="row d-flex justify-content-center my-5">
            @foreach($courses as $course)
                <div class="col-lg-4 col-sm-6 wow fadeInUp mt-3 mt-sm-0" data-wow-delay="0.3s">
                    <div class="service-item text-center border">
                        <div class="p-4">
                            <img src="{{asset('images/course-'.$course->id_courses .'.jpg')}}" alt="" width="100%" class="border">
                            <h5 class="p-4">{{ $course->title }}</h5>
                            <div class="progress">
                                <div class="progress-bar bg-{{ $course->percent >= 100 ? 'success' : 'primary' }}" style="width:{{ $course->percent }}%">{{ $course->percent }}%</div>
                            </div>
                            <div class="d-grid mt-2">
                                <a href="{{url('/member/course-details/'. $course->id_courses) }}" class="text-dark btn btn-outline-{{ $course->completed ? 'success' : 'primary' }}">{{ $course->completed ? 'পুনরায় পঠন' : 'শুরু করুন' }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>




<!-- Service End -->


@include('course.member_footer')
