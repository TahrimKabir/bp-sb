@include('course.member_header')
<div class="container-xxl py-4 mb-5">
    <div class="container">
        <a href="{{url('/member/course-details/'.$course_id)}}"><i class="fas fa-arrow-left"></i> কোর্সে ফিরে যান </a>

        <br><br>
        <div class="d-flex justify-content-between">
            <h5 class="my-2">প্রাক মূল্যায়ন <i>({{ $course->title }})</i></h5>
        </div>
        <hr>

        @if ($error = session('pre_quiz_error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ $error }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Quiz -->
        <div class="card card-body">
            <form action="{{ route('pre-quiz.submit', ['course_id' => $course_id]) }}" method="post">
                @csrf
                <p class="fw-bold border-bottom text-dark pb-1">ক. প্রশিক্ষণে অংশগ্রহণকারীর মূল্যায়ন যাচাই</p>
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                        <th>বিষয়</th>
                        <th>একমত</th>
                        <th>একমত নই</th>
                        <th>ধারণা নেই</th>
                        </thead>
                        <tbody>
                        @foreach ($radioQuestions as $key => $question)
                            <tr>
                                <td class="text-start">{{ $question->question }}</td>
                                <td><input type="radio" name="answer1[{{ $key }}]" value="1" required></td>
                                <td><input type="radio" name="answer1[{{ $key }}]" value="2"></td>
                                <td><input type="radio" name="answer1[{{ $key }}]" value="3"></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <br>
                <p class="fw-bold border-bottom text-dark pb-1">খ. এখানে কিছু বিবৃতি/ মন্তব্য রয়েছে। অনুগ্রহপূর্বক ‘একমত’, ‘একমত নই’ বা ‘ধারণা নেই’ ; (যেকোনো একটিতে আপনার মতামত বক্স সিলেক্ট করুন)</p>
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                        <th>বিষয়</th>
                        <th>একমত</th>
                        <th>একমত নই</th>
                        <th>ধারণা নেই</th>
                        </thead>
                        <tbody>
                        @foreach ($checkboxQuestions as $key => $question)
                            <tr>
                                <td class="text-start">{{ $question->question }}</td>
                                <td><input type="radio" name="answer2[{{ $key }}]" value="1" required></td>
                                <td><input type="radio" name="answer2[{{ $key }}]" value="2"></td>
                                <td><input type="radio" name="answer2[{{ $key }}]" value="3"></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success " name="submit_answer">মতামত জমা দিন <i class="fas fa-arrow-right"></i></button>
                </div>
            </form>
        </div>

    </div>
</div>

@include('course.member_footer')
