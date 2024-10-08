<?php

namespace App\Http\Controllers;

use App\Models\Mcq_question;
use Illuminate\Http\Request;

class QuestionListController extends Controller
{
    public function index()
    {
        $question = Mcq_question::all();
        return view('iqTest.question-list', compact('question'));
    }

    public function edit($id)
    {
        $question = Mcq_question::where('question_id', $id)->first();
        return view('iqTest.edit-question', compact('question'));
    }

    public function update(Request $req)
    {
        $data = array('question' => $req->question, 'correct_option' => $req->ans, 'option1' => $req->a, 'option2' => $req->b, 'option3' => $req->c, 'option4' => $req->d,'option5'=>$req->e,'option6'=>$req->f);

        Mcq_question::where('question_id', $req->cid)->update($data);
        return redirect()->back()->with('success','successfully updated');
    }
    public function delete($id){
        Mcq_question::where('question_id',$id)->delete();
        return redirect()->back()->with('success','!!record deleted!!');
    }

}
