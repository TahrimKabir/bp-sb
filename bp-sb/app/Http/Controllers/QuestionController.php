<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function getCourse($id)
    {
        $course = Course::where('id_courses', $id)->first();
        return view('create-question', compact('course'));
    }

    public function store(Request $req)
    {
        if ($req->ans!=null && $req->question!=null) {
            // $ans = implode(', ',$req->ans);
            // $cat = implode(', ',$req->qcat);
            $data = array('course_id' => $req->cid, 'question' => $req->question, 'a' => $req->a, 'b' => $req->b, 'c' => $req->c, 'd' => $req->d, 'answer' => $req->ans);
           
            Question::create($data);
            
            return redirect()->back()->with('message', 'question created');
        } else {
            return redirect()->back()->with('message', 'question category and answer must be selected');
        }

    }
}
