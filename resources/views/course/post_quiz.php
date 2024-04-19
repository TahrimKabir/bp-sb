<?php
include "member_header.php";

if(isset($_GET['course_id']) && $_GET['course_id']>0) {
    $course_id = data_validate($_GET['course_id']);
    $sql = "SELECT id_members_course_status, course_id, post_evalution FROM members_course_status WHERE member_id=".$member['id_members']." AND course_id=$course_id LIMIT 1";
    $result = $conn->query($sql);
    $course_status = $result->fetch_assoc();
    
    $sql = "SELECT title, target_trainee FROM courses WHERE id_courses=$course_id LIMIT 1";
    $result = $conn->query($sql);
    $course = $result->fetch_assoc();
    $target_trainee = explode(",", $course['target_trainee']);

    if (!in_array($member['post'], $target_trainee)) {
        header("Location: index.php");
    } elseif(empty($course_status)) {
        header("Location: details.php?course_id=".$course_status['course_id']);
    } else if($course_status['post_evalution']) {
?>
    <div class="container py-4">
        <br>
        <a href="details.php?course_id=<?= $course_id ?>"><i class="fas fa-arrow-left"></i> কোর্সে ফিরে যান</a>
        
        <div class="card w-100 w-lg-80 mx-auto p-2 p-lg-5 m-5 rounded" style="border-radius: 15px;" id="result-div">
            <div class="card-body text-center">
                <!-- <i class="fas fa-check-circle fa-5x text-success"></i> -->
                <i class="far fa-lightbulb fa-5x text-warning"></i>
                <h2 class="p-4 text-success">ধন্যবাদ !!</h2>
                <h5>আপনি অত্যন্ত সফলতার সাথে <strong class="text-info">"<?= $course['title'] ?>"</strong> কোর্সটির চূড়ান্ত মূল্যায়ন সম্পন্ন করেছেন।</h5>
                <br>
                <a href="certificate.php?course_id=<?= $course_id ?>" class="p-3 btn btn-success rounded-pill"><i class="fas fa-file-download"></i> সার্টিফিকেট ডাউনলোড করতে এখানে ক্লিক করুন</a>

            </div>
        </div>
    </div>
<?php
    } else {


        $sql = "SELECT id_questions, course_id, qus_cat, ques_type, question FROM questions WHERE qus_cat LIKE '%post_evaluation%' AND ques_type='radio'";
        $result = $conn->query($sql);
        $radio_questions = $result->fetch_all(MYSQLI_ASSOC);

        $sql = "SELECT id_questions, course_id, qus_cat, ques_type, question FROM questions WHERE qus_cat LIKE '%post_evaluation%' AND ques_type='checkbox'";
        $result = $conn->query($sql);
        $checkbox_questions = $result->fetch_all(MYSQLI_ASSOC);

?>
        <!-- Course 1 Chapter 1 -->
        <div class="container-xxl py-4 mb-5">
            <div class="container">
                <a href="details.php?course_id=<?= $course_id ?>"><i class="fas fa-arrow-left"></i> কোর্সে ফিরে যান</a>
                <br><br>
                <div class="d-flex justify-content-between">
                    <h5 class="my-2">চূড়ান্ত মূল্যায়ন <i>(<?= $course['title'] ?>)</i></h5>
                </div>
                <hr>

                <?php  if($error = get_error('post_quiz_error')) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><?= $error ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
                <!-- Quiz -->
                <div class="card card-body">
                    <form action="" method="post">
                        <p class="fw-bold border-bottom text-dark pb-1">ক. প্রশিক্ষণে অংশগ্রহণকারীর মূল্যায়ন যাচাই</p>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                            <thead>
                                <th>বিষয়</th>
                                <th>খুব সন্তোষজনক</th>
                                <th>মোটামুটি সন্তোষজনক</th>
                                <th>সন্তোষজনক  না</th>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($radio_questions as $key => $question) {
                                        echo '<tr>
                                                <td class="text-start">'.$question['question'].'</td>
                                                <td><input type="radio" name="answer1['.$key.']" value="1" required></td>
                                                <td><input type="radio" name="answer1['.$key.']" value="2"></td>
                                                <td><input type="radio" name="answer1['.$key.']" value="3"></td>
                                            </tr>';
                                    }
                                ?>
                            </tbody>
                            </table>
                        </div>
                        
                        <br>
                        <p class="fw-bold border-bottom text-dark pb-1">খ. এখানে কিছু বিবৃতি/ মন্তব্য রয়েছে। অনুগ্রহপূর্বক ‘একমত’, ‘একমত নই’ বা  ‘ধারণা নেই’ ; (যেকোনো  একটিতে  আপনার মতামত বক্স সিলেক্ট করুন)</p>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                            <thead>
                                <th>বিষয়</th>
                                <th>একমত</th>
                                <th>একমত নই</th>
                                <th>ধারণা নেই</th>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($checkbox_questions as $key => $question) {
                                        echo '<tr>
                                                <td class="text-start">'.$question['question'].'</td>
                                                <td><input type="radio" name="answer2['.$key.']" value="1" required></td>
                                                <td><input type="radio" name="answer2['.$key.']" value="2"></td>
                                                <td><input type="radio" name="answer2['.$key.']" value="3"></td>
                                            </tr>';
                                    }
                                ?>
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
       
<?php
        }
    } else {
        header("Location: course.php?course_id=".$course_status['course_id']);
}
echo "<script>
            $(document).ready(function() {
                 $('.back-to-top').addClass('d-none');
            });
    </script>";
include "member_footer.php";
?>

<?php
    if(isset($_POST['submit_answer'])) {
        $member_id = $member['id_members'];
        $status_table_id = $course_status['id_members_course_status'];
        $group_a = str_replace('"','', json_encode($_POST['answer1']));
        $group_b = str_replace('"','', json_encode($_POST['answer2']));
    
        $sql = "INSERT INTO survey(member_id, status_table_id, evaluation_type, group_a, group_b, created_at) VALUES ($member_id, $status_table_id, 'post', '$group_a', '$group_b', now())";
        $result = $conn->query($sql);
    
        if($result) {
            $sql = "UPDATE members_course_status SET post_evalution=1,  course_status='complete', complete_date=now() WHERE id_members_course_status=$status_table_id";
            $result = $conn->query($sql);
            if($result) {
                $sql = "SELECT id_members_course_status,course_id, started_at, complete_date, send_data_pims, data_send_at FROM members_course_status WHERE member_id=".$member['id_members']." AND course_id=$course_id LIMIT 1";
                $result = $conn->query($sql);
                $course_status = $result->fetch_assoc();
    
                if($course_status['send_data_pims'] != 'YES') {
                     $sen_data = send_course_data($_SESSION['member_bpid'], $course['pims_id'], $course_status['started_at'], $course_status['complete_date'], "");
    
                    if($sen_data=="send" || $sen_data=="already-send") {
                        $status = "YES";
                    } else {
                        $status = "PROBLEM";
                    }
                    $sql = "UPDATE members_course_status SET send_data_pims='$status', data_send_at=now() WHERE id_members_course_status=$status_table_id";
                    $result = $conn->query($sql);
                }
            }
            header("Location: post_quiz.php?course_id=".$course_status['course_id']);
        } else {
            set_error('post_quiz_error', 'Something Went Wrong! Please try again later.');
        }
    }