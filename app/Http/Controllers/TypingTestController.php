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

    public function editQuestion($id)
    {

        $question = TypingTestQuestion::where('question_id', $id)->first();

        if (!$question) {
            abort(404);
        }

        // Pass the question data to the edit question view
        return view('typingTest.edit-question-page', compact('question'));
    }
    public function updateQuestion(Request $request)
    {
        // Validation rules
        $rules = [
            'question_id' => 'required|exists:typing_test_questions,question_id',
            'question_content' => 'required|string',
            'duration_in_seconds' => 'required|integer|min:1',
        ];

        $messages = [
            'question_id.required' => 'The question ID is required.',
            'question_id.exists' => 'The specified question ID does not exist.',
            'question_content.required' => 'The question content is required.',
            'question_content.string' => 'The question content must be a string.',
            'duration_in_seconds.required' => 'The duration in seconds is required.',
            'duration_in_seconds.integer' => 'The duration must be an integer.',
            'duration_in_seconds.min' => 'The duration must be at least 1 second.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return the error messages
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $question = TypingTestQuestion::where('question_id', $request->input('question_id'))->first();

        // If the question is not found, return a 404 error
        if (!$question) {
            abort(404);
        }

        // Update the question with the input data
        TypingTestQuestion::where('question_id', $request->input('question_id'))->update([
            'content' => $request->input('question_content'),
            'time_in_seconds' => $request->input('duration_in_seconds'),
        ]);

        // Redirect with success message
        return redirect()->back()->with('success', 'Question updated successfully.');
    }


    public function storeQuestion(Request $request)
    {
        // Validation rules
        $rules = [
            'question_content' => 'required|string',
            'duration_in_seconds'=>'required'
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

        TypingTestQuestion::create([
            'content' => $request->input('question_content'),
            'time_in_seconds'=>$request->input('duration_in_seconds'),
        ]);

        // Redirect with success message
        return redirect()->back()->with('success', 'Question created successfully.');
    }


    public function deleteQuestion($question_id)
    {

        TypingTestQuestion::where('question_id',$question_id)->delete();

        // Redirect or return a response as needed
        return redirect()->back()->with('success', 'Question deleted successfully');
    }


}
