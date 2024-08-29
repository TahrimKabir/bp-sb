@include('course.member_header')

<div class="container py-4">
    <br>
    <a href="{{ url('/member/course-details/'.$course->id_courses) }}"><i class="fas fa-arrow-left"></i>  কোর্সে ফিরে যান</a>
    <div class="card w-100 w-lg-80 mx-auto p-2 p-lg-5 m-5 rounded" style="border-radius: 15px;" id="result-div">
        <div class="card-body text-center">
            <i class="far fa-lightbulb fa-5x text-warning"></i>
            <h2 class="p-4 text-success">ধন্যবাদ !!</h2>
            <h5>আপনি অত্যন্ত সফলতার সাথে <strong class="text-info">{{ $course->title }}</strong> কোর্সটির প্রাথমিক মূল্যায়ন সম্পন্ন করেছেন।</h5>
            <br>
            <a href="{{ url('/member/course/lesson/'.$lesson->id_lessons) }}" class="p-3 btn btn-danger rounded-pill fw-bold"> এই কোর্সটির প্রথম পাঠ সম্পন্ন করতে এখানে ক্লিক করুন <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</div>

@include('course.member_footer')
