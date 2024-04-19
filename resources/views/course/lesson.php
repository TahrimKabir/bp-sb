<?php include "member_header.php"; ?>

<?php
if(isset($_GET['lesson_id']) && $_GET['lesson_id']>0 && file_exists("lessons/lesson_id_".$_GET['lesson_id'].".php")) {
    $lesson_id = $_GET['lesson_id'];
    $sql = "SELECT id_lessons,courses_id,lesson_no FROM lessons WHERE id_lessons=$lesson_id LIMIT 1";
    $result = $conn->query($sql);
    $lesson = $result->fetch_assoc();

    if($lesson['lesson_no']==1) {
        $sql = "SELECT id_members_course_status, pre_evalution FROM members_course_status WHERE member_id=".$member['id_members']." AND course_id=".$lesson['courses_id']." LIMIT 1";
        $result = $conn->query($sql);
        $course_status = $result->fetch_assoc();
        if(!$course_status['pre_evalution']) {
            header("Location: details.php?course_id=".$lesson['courses_id']);
        }
    } else {
        $sql = "SELECT id_members_course_status, lesson_".($lesson['lesson_no']-1)." FROM members_course_status WHERE member_id=".$member['id_members']." AND course_id=".$lesson['courses_id']." LIMIT 1";
        $result = $conn->query($sql);
        $course_status = $result->fetch_assoc();

        if(!$course_status["lesson_".($lesson['lesson_no']-1)]) {
            header("Location: details.php?course_id=".$lesson['courses_id']);
        }
    }
    
    $update_sql = '';
    if($lesson['courses_id']==3) $update_sql = ", course_status=CASE WHEN course_status='unseen' THEN 'continue' END, started_at=now()";
    
    $sql = "UPDATE members_course_status SET lesson_".$lesson['lesson_no']."=1 $update_sql WHERE id_members_course_status=".$course_status['id_members_course_status'];
    $result = $conn->query($sql);

   include_once "lessons/lesson_id_$lesson_id.php";
} else {
    header("Location: index.php");
}
?>

<?php include "member_footer.php"; ?>