<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Mcq_question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {

        return view('iqTest.create-question');
    }

    public function store(Request $req)
    {
        // Validate required fields
        if ($req->ans != null && $req->question != null && $req->type != null) {
            // Create an array of data to be saved
            $data = [
                'question' => $req->question,
                'correct_option' => $req->ans,
                'option1' => $req->a,
                'option2' => $req->b,
                'option3' => $req->c,
                'option4' => $req->d,
                'option5' => $req->e,
                'option6' => $req->f,
                'type' => $req->type // Include the question type (math/others)
            ];

            // Create the question in the database
            Mcq_question::create($data);

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Question created successfully');
        } else {
            // Redirect back with a failure message if required fields are missing
            return redirect()->back()->with('fail', 'All required fields must be filled');
        }
    }

}
