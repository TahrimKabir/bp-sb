<!-- Course 2 Chapter 4 -->

@include('course.member_header')
<div class="container-xxl py-4 mb-5">
    <div class="container">
        <a href="{{url('/member/course-details/2')}}"><i class="fas fa-arrow-left"></i> কোর্সে ফিরে যান </a>
        <br><br>
        <h5>পাঠ-০৪</h5>
        <hr>

        <br>
        <h6>লিঙ্গীয় সহিংসতার শিকার ব্যক্তিকে সেবা প্রদানঃ</h6>
        <div class="text-center mt-3">
            <img src="{{asset('/img/course2/c2c4.jpg')}}" alt="" class="w-100 mx-auto w-md-90 w-lg-50">
        </div>

        <div class="d-flex justify-content-between mt-5">
            <a href="{{url('/member/course/lesson/10')}}" class="btn btn-outline-primary rounded-pill"><i class="fas fa-arrow-left"></i> পূর্ববর্তী </a>
            <a href="{{url('/member/course/lesson/12')}}" class="btn btn-outline-primary rounded-pill">পরবর্তী <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</div>
<!-- Course 2 Chapter 4 -->
@include('course.member_footer')