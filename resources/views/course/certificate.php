<?php
include_once '../db_conn.php';

require_once __DIR__ . '/../vendor/autoload.php';


$sql = "SELECT id_members, name, name_bn, designation_bn FROM members WHERE id_members=" . $_SESSION['member_id'] . " LIMIT 1";
$result = $conn->query($sql);
$member = $result->fetch_assoc();

$sql = "SELECT id_members_course_status, started_at, complete_date, send_data_pims FROM members_course_status WHERE member_id=" . $member['id_members'] . " AND course_status='complete' AND course_id=".$_GET['course_id'];
$result = $conn->query($sql);
$course_status = $result->fetch_assoc();

if(empty($course_status)) {
  header("Location: index.php");
} else {
  $sql = "SELECT title, pims_id FROM courses WHERE id_courses=".$_GET['course_id'];
  $result = $conn->query($sql);
  $course = $result->fetch_assoc();

  if($course_status['send_data_pims']=="NO") {
    $sen_data = send_course_data($_SESSION['member_bpid'], $course['pims_id'], $course_status['started_at'], $course_status['complete_date'], "");

    if($sen_data=="send" || $sen_data=="already-send") {
        $status = "YES";
    } else {
        $status = "PROBLEM";
    }
      $sql = "UPDATE members_course_status SET send_data_pims='$status', data_send_at=now() WHERE id_members_course_status=".$course_status['id_members_course_status'];
      $result = $conn->query($sql);
  }

  $sql = "UPDATE members_course_status SET certificate_download='YES', certificate_download_at=now() WHERE id_members_course_status=".$course_status['id_members_course_status'];
  $result = $conn->query($sql);

  $html = '<!DOCTYPE html>
  <html>
  <head>
  <style>
  h1 {
    // color: #F9CB37;
    // color: #056839;
    color: #1e285e;
    //font-family: verdana;
    font-size: 300%;
  }
  h2 {
    color: #056839;
    //font-family: aspire;
    font-size: 230%;
  }
  h3 {
    color: #c99c0a;
    font-size: 180%;
  }
  h6 {
    color: #06BBCC;
    //font-family: nikosh;
    font-size: 180%;
    padding: 10px 0;
  }
  p {
    //font-family: jomolhari;
    font-size: 120%;
    font-weight: bold;
  }
  b {
    font-size: 120%;
  }
  </style>
  </head>
  <body>

  <table border="0" style="width:92%; font-size:14px; border-collapse: collapse; text-align:center;margin: 0 auto;" cellpadding="4">
      <tr>
        <td style="width: 33%; text-align:left;"><img src="../img/bdpolice-logo.png" alt="" height="70px"></td>
        <td style="width: 34%; text-align:center;"><img src="../img/logo.png" alt="" height="70px" ></td>
        <td style="width: 33%; text-align:right;"><img src="../img/unwomen-logo.png" alt="" height="60px" ></td>
      </tr>
      <tr>
        <td colspan="3">
        <br> <br><br>
          <h1><u>সমাপনী সনদ</h1><br>
          <p>এই মর্মে প্রত্যয়ন করা হচ্ছে যে, </p><br>
          <h2>'. $member['name_bn'] .'</h2><h3>'. $member['designation_bn'] .'</h3>'. $_SESSION['member_bpid'] .' <br><br>
          <h6>"'. $course['title'] .'"</h6> <br>
          <p> সংশ্লিষ্ট ৭দিন ব্যাপী অনলাইন কোর্সটি '. BanglaConverter::en2bn(date_format(date_create($course_status['complete_date']),"d-m-Y")) .' তারিখে সম্পন্ন করেছেন।</p> <br>
          <br>

        </td>
      </tr>
      <tr>
        <td>
          <br> 
          <br> 
          <img src="../img/add-dig-2.png" alt="" height="50px">
          <hr>
          <b>অ্যাডিশনাল ডিআইজি <br> ট্রেনিং-২ শাখা</b>
        </td>
        <td></td>
        <td>
          <br> 
          <br> 
          <img src="../img/bpm-dig-sign.png" alt="" height="50px">
          <hr>
          <b>সভাপতি <br> বাংলাদেশ পুলিশ উইমেন নেটওয়ার্ক</b>
        </td>
      </tr>
  </table>

  </body>
  </html>';
  
  // <p>'. BanglaConverter::en2bn(date_format(date_create($govt_order_date),"d-m-Y"))  .' তারিখের সরকারি আদেশ নং এর প্রেক্ষিতে </p><br>

  $mpdf = new \Mpdf\Mpdf([
      'default_font' => 'nikosh',
      'format' => 'A4-L',
      'default_font_size' => 10,
      ]);

  $mpdf->SetMargins(0,0,28);
  $mpdf->SetWatermarkImage("../img/certificate-bg.png", 1, array(285, 195), 'P');
  $mpdf->showWatermarkImage = true;

  $mpdf->WriteHTML($html);
  $mpdf->Output($_SESSION['member_bpid'].'_certificate_'.date("Y-m-d_h-ia").'.pdf', 'I');

}