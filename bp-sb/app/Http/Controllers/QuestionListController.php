<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionListController extends Controller
{
    public function index($id)
    {
        $question = Question::where('course_id', $id)->get();
        return view('view-question-list', compact('question'));
    }

    public function edit($id)
    {
        $question = Question::where('id_questions', $id)->first();
        return view('edit-question', compact('question'));
    }

    public function update(Request $req)
    {
        $data = array('question' => $req->question, 'answer' => $req->ans, 'a' => $req->a, 'b' => $req->b, 'c' => $req->c, 'd' => $req->d);
        
        Question::where('id_questions', $req->cid)->update($data);
        return redirect()->back();
    }

}
