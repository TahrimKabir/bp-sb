<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $course = Course::all();
        return view('create-exam', compact('course'));
    }

    public function store(Request $req)
    {
       if($req->exam==null||$req->course_id==null||$req->details==null||$req->type==null){
        return redirect()->back()->with('fail', 'Exam details/exam-title/course must be filled');
       }else{
        $check = Exam::where('exam_name', $req->exam)->where('course_id', $req->course_id)->where('type', $req->type)->get();
        if (count($check) == 0) {
            $data = array('exam_name' => $req->exam, 'course_id' => $req->course_id, 'type' => $req->type, 'details' => $req->details, 'status' => 'deactive');
            Exam::create($data);
            return redirect()->back()->with('success', 'Exam added successfully');
        } else {
            return redirect()->back()->with('fail', 'could not create new as  exam/course/type already exists!');
        }
       }
       

    }
}
