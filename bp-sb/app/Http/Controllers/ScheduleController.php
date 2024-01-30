<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\MembersCourseStatus;
use Illuminate\Support\Facades\Hash;
use App\Models\Exam_credential;
class ScheduleController extends Controller
{
    
    public function getCourse($id){
        $course = Course::where('id_courses',$id)->first();
        // dd($course->Cstatus);
        return view('create-schedule',compact('course'));
    }

    public function update(Request $req){
        if($req->bpid!=null){
            foreach($req->bpid as $b){
                // 'pin'=>mt_rand(100000, 999999)
             $data = array('exam_date'=>$req->examdate,'exam'=>'1');
             $pin = array('mcstatus_id'=>$b,'pin_number'=>Hash::make(mt_rand(100000, 999999)),'start'=>date('Y-m-d H:i', strtotime($req->examdate . ' ' . $req->from)));
             Exam_credential::create($pin);
             MembersCourseStatus::where('id_members_course_status',$b)->update($data);
            }
            return redirect()->back();
        }
    }

}
