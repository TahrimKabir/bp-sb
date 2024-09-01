<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamListController extends Controller
{
    public function index()
    {
        $exam = Exam::all();
        return view('exam-list', compact('exam'));
    }

    public function edit($id)
    {

        $exam = Exam::where('exam_id', $id)->first();
        $course = Course::all();
        return view('edit-exam', compact('course', 'exam'));
    }
    public function update(Request $req)
    {
        // || $req->course_id == null may come later
        if ($req->exam == null  || $req->details == null || $req->type==null) {
            return redirect()->back()->with('fail', 'Exam details/exam-title/course/type must be filled');
        } else {
            $check = Exam::where('exam_name', $req->exam)->where('type', $req->type)->get();
            if (count($check) == 0) {
                $data = array('exam_name' => $req->exam, 'type' => $req->type, 'details' => $req->details, 'status' => 'deactive');
                Exam::where('exam_id', $req->id)->update($data);
                return redirect()->back()->with('success', 'Exam updated successfully');
            } else {
                return redirect()->back()->with('fail', 'could not create new as  exam/course/type already exists!');
            }
        }

    }

    public function delete($id)
    {
        Exam::where('exam_id', $id)->delete();
        return redirect()->back()->with('fail', 'Exam deleted successfully');
    }
}
