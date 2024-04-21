<!-- Course 2 Chapter 3 -->

@include('course.member_header')
<div class="container-xxl py-4 mb-5">
    <div class="container">
        <a href="{{url('/member/course-details/2')}}"><i class="fas fa-arrow-left"></i> কোর্সে ফিরে যান </a>
        <br><br>
        <h5>পাঠ-০৩</h5>
        <hr>
        <h6>জেন্ডারভিত্তিক সহিংসতার ফলাফলঃ</h6>
        <br>

        <div>
            <h6>যৌন হয়রানির ফলাফলঃ</h6>
            <p>যে কোন প্রকার যৌন হয়রানির গুরুত্ব সহকারে নেওয়া উচিত, কেননা, যৌন হয়রানির শিকার যে হয় তার অনেক নেতিবাচক ফলাফল সৃষ্টি হয় । এই ফলাফল গুলো শারীরিক, মানসিক অথবা উভয়ই হতে পারে-</p>

             <div class="row">
                <div class="col-sm-6 col-lg-4 border px-0">
                    <div class="alert alert-primary">শারীরিক সমস্যা সমূহ</div>
                    <ul>
                        <li>বিতৃষ্ণাবোধ,</li>
                        <li>মাথাব্যাথা, পাকস্থলির অনিয়ম, হৃৎপিন্ডের সমস্যা ইত্যাদি</li>
                        <li>ওজন হারানো / বাড়া</li>
                        <li>স্থান ত্যাগ করা</li>
                        <li>জৈবিক চাহিদা কমে যাওয়া / অতিরিক্ত খাদ্যাহার</li>
                        <li>মাদকের উপর নির্ভরশীলতা</li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-4 border px-0">
                    <div class="alert alert-primary">মানসিক সমস্যা সমূহ</div>
                    <ul>
                        <li>নিজের প্রতি শ্রদ্ধা কমে যাওয়া</li>
                        <li>অপরাধীর প্রতি তীব্র ঘৃণা</li>
                        <li>অন্যদের প্রতি সন্দেহপ্রবণ</li>
                        <li>নিজেকে অপমানিত, অপরাধী মনে হওয়া</li>
                        <li>আক্রোশ বোধ করা</li>
                        <li>সর্বদা নিজেকে অনিরাপদ ভাবা</li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-4 border px-0">
                    <div class="alert alert-primary">কর্মক্ষেত্রের সমস্যা সমূহ</div>
                    <ul>
                        <li>ভূক্তভোগী কাজের প্রতি মনোসংযোগ করতে পারে না</li>
                        <li>যৌন হয়রানি অশ্রদ্ধা এবং অপমানজনক পরিবেশ তৈরি করে</li>
                        <li>ভুক্তভোগী প্রতিষ্ঠানকে ঘৃণা করে</li>
                        <li>পুরুষ বা মহিলা ভুক্তভোগীকে আলাদা করে দেওয়া জরুরী হতে পারে</li>
                    </ul>
                </div>
            </div>

            <br>
            <div class="text-center  d-none d-md-block">
                <img src="{{asset('/img/course2/c2c3.png')}}" alt="" width="100%">
            </div>
            <div class="text-center s-sm-block d-md-none d-lg-none">
                <img src="{{asset('/img/course2/c2c3_mobile.png')}}" alt="" width="100%">
            </div>

            <hr>
            <div class="row text-center">
                <h4 class="py-4 text-danger"><u>লিঙ্গভিত্তিক সহিংসতার ধরণসমূহঃ</u></h4>
                <div class="col-md-6">
                    <img src="{{asset('/img/course2/c2c31.jpg')}}" alt="" width="100%">
                </div>
                <div class="col-md-6">
                    <img src="{{asset('/img/course2/c2c312.png')}}" alt="" width="100%">
                </div>
            </div>
            <hr>
            <div class="text-center">
                <img src="{{asset('/img/course2/c2c32.jpg')}}" alt="" class="w-100 mx-auto w-md-90 w-lg-80 w-xl-75">
            </div>
            <br>
        </div>

        <div class="d-flex justify-content-between mt-5">
            <a href="{{url('/member/course/lesson/9')}}" class="btn btn-outline-primary rounded-pill"><i class="fas fa-arrow-left"></i> পূর্ববর্তী </a>
            <a href="{{url('/member/course/lesson/11')}}" class="btn btn-outline-primary rounded-pill">পরবর্তী <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</div>
<!-- Course 2 Chapter 3 -->
@include('course.member_footer')
