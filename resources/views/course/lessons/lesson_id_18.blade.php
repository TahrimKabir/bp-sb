<!-- Course 3 Chapter 6 -->

@include('course.member_header')
<div class="container-xxl py-4 mb-5">
    <div class="container">
        <a href="{{url('/member/course-details/3')}}"><i class="fas fa-arrow-left"></i> কোর্সে ফিরে যান </a>
        <br><br>
        <h5>পাঠ-০৬</h5>
        <hr>

        <br>
        <!-- <h6>সার্ভিস ডেস্কের কার্যক্রমঃ</h6> -->
        <div class="row text-center">
            <h4 class="py-4 text-danger mx-auto d-md-none"><u>প্রতিবন্ধী সেবাপ্রার্থীর ক্ষেত্রে করনীয়ঃ</u></h4>
            <div class="col-12 d-flex justify-content-center">
                <img src="{{asset('/img/course3/c3c6.png')}}" alt="" class="d-none d-md-block mx-auto w-100 w-lg-75 w-xl-60">
                <img src="{{asset('/img/course3/c3c6_mobile.png')}}" alt="" class="w-100 mx-auto d-md-none">
            </div>
        </div>
        <hr>
        <div>
            <h6>প্রতিবন্ধী সেবাপ্রার্থীর ক্ষেত্রে করনীয়ঃ</h6>
            <ol style="list-style-type: bengali;text-align:justify;">
                <li>প্রতিবন্ধী ব্যাক্তির অধিকার ও সুরক্ষা আইন, ২০১৩ অনুসরনপূর্বক প্রয়োজনীয় আইনগত সহযোগিতা প্রদান করবেন।</li>
                <li>প্রতিবন্ধী ব্যক্তিদের সাথে অতি সংবেদনশীল, ধৈর্য্যশীল ও মানবিক আচরন করবেন। এমন কোন আচরণ করবেন না যা প্রতিবন্ধী ব্যক্তির মনে ভীতি সঞ্চার করে। </li>
                <li>প্রতিবন্ধী ব্যক্তির অভিযোগ/সমস্যা যথাযথভাবে অনুধাবনের লক্ষ্যে আইনানুগ অভিভাবক অথবা বিশেষ ক্ষেত্রে সমাজসেবা কর্মকর্তার সহযোগিতা গ্রহণ করবেন।</li>
                <li>সংবেদনশীল আচরণের মাধ্যমে তাদের সমস্যা উপলব্ধি করে প্রয়োজনীয় ব্যবস্থা গ্রহণ করবেন।</li>
                <li>সরকার প্রদত্ত সেবা সম্পর্কে প্রতিবন্ধী ব্যক্তির অভিভাবককে অবহিত করবেন।</li>
            </ol>
        </div>
        <div class="d-flex justify-content-between mt-5">
            <a href="{{url('/member/course/lesson/17')}}" class="btn btn-outline-primary rounded-pill"><i class="fas fa-arrow-left"></i> পূর্ববর্তী </a>
            <a href="{{url('/member/course/lesson/19')}}" class="btn btn-outline-primary rounded-pill">পরবর্তী <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</div>
<!-- Course 3 Chapter 5 -->
@include('course.member_footer')
