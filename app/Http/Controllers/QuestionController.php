<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Mcq_question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {

        return view('create-question');
    }

    public function store(Request $req)
    {
        if ($req->ans!=null && $req->question!=null) {
            // $ans = implode(', ',$req->ans);
            // $cat = implode(', ',$req->qcat);
            $data = array('question' => $req->question, 'correct_option' => $req->ans, 'option1' => $req->a, 'option2' => $req->b, 'option3' => $req->c, 'option4' => $req->d,'option5'=>$req->e,'option6'=>$req->f );

            Mcq_question::create($data);

            return redirect()->back()->with('success', 'question created');
        } else {
            return redirect()->back()->with('fail', 'required fields must be selected');
        }

    }
}
