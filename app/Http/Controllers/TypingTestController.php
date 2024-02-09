<?php

namespace App\Http\Controllers;

use App\Models\TypingTestQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypingTestController extends Controller
{
    public function showQuestionList()
    {
        $questionList = TypingTestQuestion::all();
        return view('typingTest.question-list-page', compact('questionList'));
    }
   public function createQuestion(){
        return view('typingTest.create-question-page');
   }
    public function storeQuestion(Request $request)
    {
        // Validation rules
        $rules = [
            'question_content' => 'required|string',
        ];


        $messages = [
            'question_content.required' => 'The question content is required.',
            'question_content.string' => 'The question content must be a string.',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return the error messages
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If validation passes, create a new TypingTestQuestion
        TypingTestQuestion::create([
            'content' => $request->input('question_content'),
        ]);

        // Redirect with success message
        return redirect()->back()->with('success', 'Question created successfully.');
    }


}
