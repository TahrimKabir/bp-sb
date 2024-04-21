<!-- Course 3 Chapter 4 -->

@include('course.member_header')
<div class="container-xxl py-4 mb-5">
    <div class="container">
        <a href="{{url('/member/course-details/3')}}"><i class="fas fa-arrow-left"></i> কোর্সে ফিরে যান </a>
        <br><br>
        <h5>পাঠ-০৪</h5>
        <hr>

        <br>
        <!-- <h6>সার্ভিস ডেস্কের কার্যক্রমঃ</h6> -->
        <div class="row text-center">
            <h4 class="py-4 text-danger mx-auto d-md-none"><u>শিশু সেবা প্রার্থীদের ক্ষেত্রে করণীয়ঃ</u></h4>
            <div class="col-12 d-flex justify-content-center">
                <img src="{{asset('/img/course3/c3c4.png')}}" alt="" class="d-none d-md-block mx-auto w-100 w-lg-80">
                <img src="{{asset('/img/course3/c3c4_mobile.png')}}" alt="" class="w-100 mx-auto d-md-none">
            </div>
        </div>
        <hr>
        <div>
            <h6>শিশু সেবা প্রার্থীদের ক্ষেত্রে করণীয়ঃ</h6>
            <ol style="list-style-type: bengali;text-align:justify;">
                <li>শিশু আইন, ২০১৩ অনুসরণপূর্বক প্রয়োজনীয় আইনগত সহযোগিতা প্রদান করবেন। </li>
                <li>শিশুর প্রতি সংবেদনশীল, যত্নশীল ও শিশুবান্ধব আচরণ করবেন। এমন কোন আচরণ করবেন না যা শিশুর মনে ভীতির সঞ্চার করে। </li>
                <li>কোন শিশুকে পুলিশ হেফাজতে রাখা হলে শিশু বিষয়ক পুলিশ কর্মকর্তার মাধ্যমে তার আইনানুগ অভিভাবক, প্রবেশন কর্মকর্তাকে জানাবেন। </li>
                <li>শিশুকে অপরাধী হিসেবে বিবেচনা করা যাবে না, শিশুর সাথে অভিভাবকসুলভ আচরণ করবেন। </li>
                <li>বৈধ অভিভাবক পাওয়া না গেলে শিশু বিষয়ক কর্মকর্তার মাধ্যমে সেফ হোম/আশ্রয় কেন্দ্রে প্রেরণের উদ্যোগ গ্রহণ করবেন।</li>
            </ol>
        </div>
        <div class="d-flex justify-content-between mt-5">
            <a href="{{url('/member/course/lesson/15')}}" class="btn btn-outline-primary rounded-pill"><i class="fas fa-arrow-left"></i> পূর্ববর্তী </a>
            <a href="{{url('/member/course/lesson/17')}}" class="btn btn-outline-primary rounded-pill">পরবর্তী <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</div>
<!-- Course 3 Chapter 4 -->
@include('course.member_footer')
