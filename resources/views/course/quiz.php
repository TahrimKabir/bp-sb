<?php
include "member_header.php";

if(isset($_GET['course_id']) && $_GET['course_id']>0) {
    $course_id = data_validate($_GET['course_id']);
    $sql = "SELECT id_members_course_status, course_id, exam FROM members_course_status WHERE member_id=".$member['id_members']." AND course_id=$course_id LIMIT 1";
    $result = $conn->query($sql);
    $course_status = $result->fetch_assoc();

    $sql = "SELECT COUNT(*) as total FROM lessons WHERE courses_id=$course_id";
    $result = $conn->query($sql);
    $total_lesson = $result->fetch_assoc()['total'];

    $sql = "SELECT (lesson_1+lesson_2+lesson_3+lesson_4+lesson_5+lesson_6+lesson_7+lesson_8) as total FROM members_course_status WHERE member_id=".$member['id_members']." AND course_id=$course_id";
    $result = $conn->query($sql);
    $complete_lesson = $result->fetch_assoc()['total'];

    
    if(empty($course_status) || $course_status['exam'] || $complete_lesson != $total_lesson) {
        header("Location: details.php?course_id=".$course_status['course_id']);
    }

    $sql = "SELECT title, target_trainee FROM courses WHERE id_courses=$course_id LIMIT 1";
    $result = $conn->query($sql);
    $course = $result->fetch_assoc();
    $target_trainee = explode(",", $course['target_trainee']);

    if (!in_array($member['post'], $target_trainee)) {
        header("Location: index.php");
    }

    $sql = "SELECT * FROM questions WHERE course_id=$course_id AND qus_cat='quiz' ORDER BY RAND() LIMIT 10";
    $result = $conn->query($sql);
    $questions = json_encode($result->fetch_all(MYSQLI_ASSOC));

} else {
    header("Location: details.php?course_id=".$course_status['course_id']);
}

?>
<!-- Course 1 Chapter 1 -->
<div class="container-xxl py-4 mb-5">
    <div class="container">
        <a href="details.php?course_id=<?= $course_id ?>"><i class="fas fa-arrow-left"></i> কোর্সে ফিরে যান</a>
        <br><br>
        <div class="d-flex justify-content-between">
            <h5 class="my-2">মূল্যায়ন <i>(<?= $course['title'] ?>)</i></h5>
        </div>
        <hr>
        <!-- Quiz -->
        <div class="card card-body" id="question-body">
            <div class="question bg-white">
                <div class="d-flex flex-row align-items-center question-title bg-light p-3">
                    <h5><span class="text-primary me-2">প্রশ্ন <span id="question-no">0</span>.</span> <span class="ml-2" id="question-title">Question</span></h5>
                    
                </div>
                <div class="d-flex justify-content-between">
                    <div class="mx-3" id="question-options">
                    </div>
                    <div class="d-flex justify-content-center align-items-center p-3">
                        <i class="far fa-check-circle fa-3x text-success d-none" id="correct-ans-icon"></i>
                        <i class="far fa-times-circle fa-3x text-danger d-none" id="wrong-ans-icon"></i>
                    </div>
                </div>
            </div>

            <div class="alert alert-danger fw-bold d-none" id="qus-error" role="alert">একটি অপশন সিলেক্ট করুন</div>

            <div class="d-flex justify-content-between mt-5">
                <div><small class="text-start text-muted" id="qus-point">২ / ৩ পয়েন্ট</small></div>
               <div>
                <button type="submit" class="btn btn-success rounded-pill" id="submit-answer">সাবমিট <i class="fas fa-arrow-right"></i></button>
                    <button type="submit" class="btn btn-primary rounded-pill d-none" id="next-question">পরবর্তী <i class="fas fa-arrow-right"></i></button>
               </div>
            </div>
        </div>

        <div class="card w-100 w-lg-80 mx-auto p-2 m-2 d-none rounded" style="border-radius: 15px;" id="result-div">
            <div class="card-body text-center">
                <!-- <i class="fas fa-check-circle fa-5x text-success"></i> -->
                <i class="fas fa-award fa-5x text-warning"></i>
                <h2 class="p-4 text-success">অভিনন্দন !!</h2>
                <h5>আপনি অত্যন্ত সফলতার সাথে <strong class="text-info">"<?= $course['title'] ?>"</strong> কোর্সটির মূল্যায়ন সম্পন্ন করেছেন।</h5>
                <br>
                <h6 class="text-success">আপনার স্কোরঃ <span id="result-score">১২/২০</span></h6>
                <br>
                <?php if($course_id != 3) { ?>
                    <a href="post_quiz.php?course_id=<?= $course_id ?>" class="p-3 btn btn-danger rounded-pill fw-bold">চূড়ান্ত জরিপে অংশগ্রহণ করে কোর্সটি সম্পন্ন করতে এখানে ক্লিক করুন <i class="fas fa-arrow-right"></i></a>
                <?php } else { ?>
                    <a href="certificate.php?course_id=<?= $course_id ?>" class="p-3 btn btn-success rounded-pill"><i class="fas fa-file-download"></i> সার্টিফিকেট ডাউনলোড করতে এখানে ক্লিক করুন</a>

                <?php } ?>
            </div>
        </div>

        <div class="card w-75 mx-auto p-2 m-2 d-none rounded" style="border-radius: 15px;" id="error-div">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
                <h2 class="p-4 text-secondary">Oops !! Something Went Wrong.</h2>
                <p>Please Try Again Later.</p>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        const toBn = function(n) {
            n = n.toString();
            return n.replace(/\d/g, d => "০১২৩৪৫৬৭৮৯"[d]);
        }

        var questions = JSON.parse(JSON.stringify(<?= $questions ?>));
        var cur_qus_index = 0;
        var total_qus = questions.length;
        var corr_ans = 0;
        var final_submit = false;

        $('#qus-point').text(toBn(corr_ans)+" / "+ toBn(total_qus) +" পয়েন্ট");
        function qus_render(question) {
            
            $('#correct-ans-icon').addClass('d-none');
            $('#wrong-ans-icon').addClass('d-none');
            $('#submit-answer').removeClass('d-none');
            $('#next-question').addClass('d-none');

            $('#question-title').text(question.question);
            $('#question-no').text(toBn(cur_qus_index+1));

            var options_html = '<div class="p-2 mb-1" id="option-a"><label class="radio"> <input type="radio" name="qus_option" value="a"> <span>'+question.a+'</span></label></div><div class="p-2 mb-1" id="option-b"><label class="radio"> <input type="radio" name="qus_option" value="b"> <span>'+question.b+'</span></label></div>';
            if(question.ques_type=='mcq') {
                options_html += '<div class="p-2 mb-1" id="option-c"><label class="radio"> <input type="radio" name="qus_option" value="c"> <span>'+question.c+'</span></label></div><div class="p-2" id="option-d"><label class="radio"> <input type="radio" name="qus_option" value="d"> <span>'+question.d+'</span></label></div>';
            }
            $('#question-options').html(options_html);
        }
        qus_render(questions[cur_qus_index]);

        $('#submit-answer').click(function() {
            var get_ans = $("input[name='qus_option']:checked").val();
            if(get_ans) {
                var correct_ans = questions[cur_qus_index].answer;
                if(get_ans==correct_ans) {
                    $('#correct-ans-icon').removeClass('d-none');
                    $('#option-'+get_ans).addClass('alert-success');
                    corr_ans++;
                    var audio = new Audio('../audio/correct.mp3');
                    audio.play();
                } else {
                    $('#wrong-ans-icon').removeClass('d-none');
                    $('#option-'+get_ans).addClass('alert-danger');
                    $('#option-'+correct_ans).addClass('alert-success');
                    var audio = new Audio('../audio/wrong.mp3');
                    audio.play();
                }
                $('#qus-point').text(toBn(corr_ans)+" / "+ toBn(total_qus) +" পয়েন্ট");
                $('#submit-answer').addClass('d-none');
                $('#next-question').removeClass('d-none');
            } else {
                $('#qus-error').removeClass('d-none').fadeTo(2000, 500).slideUp(500, function(){
                    $("#success-alert").alert('close');
                });
            }
        });

        $('#next-question').click(function() {
            cur_qus_index++;
           
            if(final_submit) {
                $('#next-question').html('<i class="fas fa-spinner fa-pulse"></i>').attr('disabled');
                $.post("api/quiz_result_update.php",
                {
                    from: "member_panel",
                    status_table_id: <?= $course_status['id_members_course_status'] ?>,
                    mark: corr_ans,
                    course_id: <?= $course_id ?>
                },
                function(data, status){
                    if(status=='success') {
                        data = JSON.parse(data);
                        if(data.status=='success') {
                            $('#result-score').text(toBn(corr_ans)+"/"+ toBn(total_qus));
                            $('#question-body').addClass('d-none');
                            $('#result-div').removeClass('d-none');
                        } else {
                            $('#question-body').addClass('d-none');
                            $('#error-div').removeClass('d-none');
                        }
                    } else {
                        $('#question-body').addClass('d-none');
                        $('#error-div').removeClass('d-none');
                    }
                });

            } else {
                if(cur_qus_index==(total_qus-1)){ final_submit=true; }
                qus_render(questions[cur_qus_index]);
            }
        });
        
        $('.back-to-top').addClass('d-none');
    });
</script>
<?php
include "member_footer.php";
?>