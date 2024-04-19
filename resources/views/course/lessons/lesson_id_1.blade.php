<!-- Course 1 Chapter 1 -->

@include('course.member_header')
<div class="container-xxl py-4 mb-5">
    <div class="container">
        <a href="{{url('/member/course-details/1')}}"><i class="fas fa-arrow-left"></i> কোর্সে ফিরে যান </a>
        <br><br>
        <h5>পাঠ-০১</h5>

        <hr><br>
        <h6>লিঙ্গ ও জেন্ডার সম্পর্কিত ধারণাঃ</h6>

        <div class="ratio ratio-16x9 w-100 mx-auto w-sm-95 w-md-90 w-lg-80 w-xl-75">
            <iframe src="https://www.youtube.com/embed/QoxJbCNZ9Us" title="YouTube video" allowfullscreen></iframe>
        </div>

        <!-- <ul>
            <li>লিঙ্গ হলো প্রাকৃতিক বা জৈবিক বা শারীরিক কিংবা শরীরবৃত্তীয়ভাবে সৃষ্ট/ নির্ধারিত নারী-পুরুষের স্বতন্ত্রধর্মী সে সব বৈশিষ্ট্য-যা অপরিবর্তনীয় বা প্রকৃতি দ্বারা নির্ধারিত।</li>
            <li>জেন্ডার হলো সামাজিক বা সাংস্কৃতিকভাবে গড়ে ওঠা এবং সামাজিক ও সাংস্কৃৃতিক ভাবে নির্ধারিত নারী-পুরুষের পরিচয়, নারী পুরুষের মধ্যকার সম্পর্ক, সমাজ দ্বারা আরোপিত নারী পুরুষের ভূমিকা-যা পরিবর্তনীয়। সাধারণভাবে লিঙ্গ আর জেন্ডারকে এক অর্থে ব্যবহার করা হয়। কিন্তু এই দুই এর মধ্যে পার্থক্য রয়েছে। লিঙ্গ হলো, শারীরিক বৈশিষ্ট্যের ভিত্তিতে নারী ও পুরুষের মধ্যে বিদ্যমান পার্থক্য ও স্বাতন্ত্র্য আর সামাজিক ও সাংস্কৃতিকভাবে গড়ে ওঠা নারী-পুরুষের পরিচয় হচ্ছে জেন্ডার।</li>
        </ul> -->
        <br>
        <h6>লিঙ্গ ও জেন্ডার এর মধ্যে র্পাথক্যঃ</h6>
        <div class="text-center py-3">
            <img src="{{asset('/img/course1/c1c1.png')}}" class="w-md-90 w-lg-80 w-xl-75 d-none d-md-block mx-auto" alt="" id="l1img1">
        </div>

        <div class="table-responsive d-md-none">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="text-center bg-primary text-white h5">লিঙ্গ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>শারীরিক গঠন অনুযায়ী নির্ধারিত</td>
                    </tr>
                    <tr>
                        <td>প্রাকৃতিক</td>
                    </tr>
                    <tr>
                        <td>সর্বজনীন ও অপরিবর্তনীয়</td>
                    </tr>
                    <tr>
                        <td>পূর্ব নির্ধারিত ও সর্বত্র একইরকম</td>
                    </tr>
                    <tr>
                        <td>সেক্স জন্মগত, এটি নারী-পুরুষের প্রজনন অঙ্গ এবং প্রজনন কার্যাবলিকে ভিন্নভাবে নির্দেশ করে।</td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="text-center bg-primary text-white h5">জেন্ডার</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>সামাজিক ও সাংস্কৃতিক ভাবে নির্ধারিত</td>
                    </tr>
                    <tr>
                        <td>আরোপিত</td>
                    </tr>
                    <tr>
                        <td>পরিবর্তনশীল</td>
                    </tr>
                    <tr>
                        <td>সময় ও সমাজে এর পরিবর্তন ভেদে এর প্রকাশ বহুমুখী</td>
                    </tr>
                    <tr>
                        <td>জেন্ডার সামাজিক-সাংস্কৃতিক বিষয়। এটি নারীসুলভ ও পুরুষসুলভ বৈশিষ্ট্য, আচরণ, ভূমিকা প্রভৃতিকে নির্দেশ করে।</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-end">
            <a href="{{url('/member/course/lesson/2')}}" class="btn btn-outline-primary rounded-pill">পরবর্তী <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</div>
<!-- Course 1 Chapter 1 -->
@include('course.member_footer')
