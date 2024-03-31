<?php

namespace App\Http\Controllers;

use App\Models\ComputerTestQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComputerTestController extends Controller
{
    //

    public function createQuestion(){
        return view('computerTest.create-question-page');
    }


    public function storeQuestion(Request $request)
    {
        // Validation rules
        $rules = [
            'question_content' => 'required|string',

            'question_type' => 'required|in:short_question,mcq,descriptive,true_false',
            'option1' => 'nullable|string',
            'option2' => 'nullable|string',
            'option3' => 'nullable|string',
            'option4' => 'nullable|string',
            'correct_answer' => 'nullable|string',
            'marks'=>'required'
        ];

        // Custom error messages for validation
        $messages = [
            'question_content.required' => 'The question content is required.',
            'question_content.string' => 'The question content must be a string.',
            'question_type.required' => 'The question type is required.',
            'question_type.in' => 'Invalid question type.',
            'option1.string' => 'Option 1 must be a string.',
            'option2.string' => 'Option 2 must be a string.',
            'option3.string' => 'Option 3 must be a string.',
            'option4.string' => 'Option 4 must be a string.',
            'correct_answer.string' => 'The correct answer must be a string.',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create a new ComputerTestQuestion instance and store it in the database
        ComputerTestQuestion::create([
            'question_content' => $request->input('question_content'),
            'duration_in_seconds' => $request->input('duration_in_seconds'),
            'question_type' => $request->input('question_type'),
            'option1' => $request->input('option1'),
            'option2' => $request->input('option2'),
            'option3' => $request->input('option3'),
            'option4' => $request->input('option4'),
            'correct_answer' => $request->input('correct_answer'),
            'marks'=>$request->input('marks')
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Question created successfully.');
    }
}
