<?php
include_once "../../db_conn.php";

if(isset($_SESSION['member_id']) && isset($_POST['from']) && $_POST['from']=="member_panel") {
    $table_id = (int) $_POST['status_table_id'];
    $mark = (int) $_POST['mark'];
    $course_id = (int) $_POST['course_id'];
    $update_sql = '';
    // if($course_id==3) $update_sql = ", course_status='complete', complete_date=now()";
    
     $sql = "UPDATE members_course_status SET exam=1, exam_mark=$mark , exam_date=now(), course_status = CASE WHEN course_id=3 THEN 'complete' ELSE 'continue' END, complete_date=CASE WHEN course_id=3 THEN now() ELSE NULL END WHERE id_members_course_status=$table_id";
    $result = $conn->query($sql);
    
    if($result) {
        echo json_encode(['status'=>'success', 'msg'=>'Successfully Updated']);
    } else {
        echo json_encode(['status'=>'error', 'msg'=>'Something went wrong!']);
    }

}