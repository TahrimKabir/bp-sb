<!-- Course 3 Chapter 1 -->

@include('course.member_header')
<div class="container-xxl py-4 mb-5">
    <div class="container">
        <a href="{{url('/member/course-details/3')}}"><i class="fas fa-arrow-left"></i> কোর্সে ফিরে যান </a>
        <br><br>
        <h5>পাঠ-০১</h5>
        <hr>

        <br>
        <!-- <h6>সার্ভিস ডেস্কের কার্যক্রমঃ</h6> -->
        <div class="row text-center">
            <h4 class="py-4 text-danger"><u>সার্ভিস ডেস্কের কার্যক্রমঃ</u></h4>
            <div class="col-12 d-flex justify-content-center">
                <img src="{{asset('/img/course3/c3c1.png')}}" alt="" class="d-none d-md-block mx-auto w-md-90 w-lg-80 w-xl-75">
                <img src="{{asset('/img/course3/c3c1_mobile.png')}}" alt="" class="w-100 mx-auto d-md-none">
            </div>
        </div>
        <hr>
        <div>
            <h6>সার্ভিস ডেস্কের কার্যক্রমঃ</h6>
            <ol style="list-style-type: bengali;text-align:justify;">
                <li>থানায় আগত নারী, শিশু, বয়স্ক ও প্রতিবন্ধী ব্যক্তিদের সহায়ক পরিবেশে কাঙিখত আইনগত সেবা নিশ্চিত করা।</li>
                <li>নারী, শিশু, বয়স্ক ও প্রতিবন্ধী ব্যক্তিদের প্রতি সহিংসতা কার্যকরভাবে কমিয়ে আনার লক্ষ্যে সরকারী এবং বেসরকারী প্রতিষ্ঠানের সাথে প্রয়োজনীয় সমন্বয় এবং সচেতনতামূলক কার্যক্রম পরিচালনা করা। </li>
                <li>মাননীয় হাইকোর্ট, নারী ও শিশু বিষয়ক আইন এবং পুলিশ হেডকোয়ার্টার্সের নির্দেশনা অনুযায়ী নারী ও শিশু সংক্রান্ত যে সকল কার্যক্রম (যেমনঃ শিশু বিষয়ক পুলিশ কর্মকর্তার কার্যক্রম, পরিসংখ্যান সংরক্ষণ, তথ্যাদি, প্রেরণ, ইত্যাদি) চলমান রয়েছে তা সমন্বয় করা। </li>
                <li>দেওয়ানী প্রকৃতির সমস্যা হলে যথাযথ দপ্তরে প্রেরণের ব্যবস্থা করা।</li>
                <li>পুলিশ হেডকোয়ার্টার্স কর্তৃক সরবরাহকৃত সরকারী মোবাইল সিম দ্বারা ডেস্কের কার্যক্রম পরিচালনা করা। </li>
            </ol>
        </div>
        <div class="d-flex justify-content-between mt-5">

            <a href="{{url('/member/course/lesson/14')}}" class="btn btn-outline-primary rounded-pill">পরবর্তী <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</div>
<!-- Course 2 Chapter 4 -->
@include('course.member_footer')
