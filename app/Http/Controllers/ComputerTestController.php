<?php

namespace App\Http\Controllers;

use App\Models\ComputerTestQuestion;
use App\Models\QuestionSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComputerTestController extends Controller
{
    //
    public function showQuestionSetList()
    {
        $questionSets = QuestionSet::all();
        return view('computerTest.question-list-page', compact('questionSets'));
    }
    public function createQuestion(){
        return view('computerTest.create-question-page');
    }

//    public function editQuestion($id)
//    {
//
//        $question = ComputerTestQuestion::where('question_id', $id)->first();
//
//        if (!$question) {
//            abort(404);
//        }
//
//        // Pass the question data to the edit question view
//        return view('computerTest.edit-question-page', compact('question'));
//    }


    public function storeQuestion(Request $request)
    {
        // Validate the request
        $validator = $this->validateComputerTestQuestion($request);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create a new question set
        $questionSet = QuestionSet::create([
            'question_set_name' => $request->input('question_set_name'),
            'type'=>'advanced'
        ]);


        $this->processComputerTestQuestions($request, $questionSet->id);

        return redirect()->back()->with('success', 'Question set created successfully');
    }


    protected function validateComputerTestQuestion(Request $request)
    {
        Validator::extend('summernote_required', function ($attribute, $value, $parameters, $validator) {
            // Strip HTML tags and check if the content is not empty
            $plainText = strip_tags($value);
            return !empty(trim($plainText));
        });
        return Validator::make($request->all(), [
            'question_set_name' => 'required|string|max:32',
            'question_content.*' => 'required|string',
            'question_type.*' => 'required|string|in:mcq,short_question,descriptive,true_false',
            'marks.*' => 'required|numeric|min:1',
            'option1.*' => 'nullable|string',
            'option2.*' => 'nullable|string',
            'option3.*' => 'nullable|string',
            'option4.*' => 'nullable|string',
            'correct_answer.*' => 'nullable|string',

        ]);
    }

    // Process computer test questions
    protected function processComputerTestQuestions(Request $request, $questionSetId)
    {


        foreach ($request->input('question_content') as $key => $content) {
            $questionType = $request->input('question_type')[$key];

            $marks = $request->input('marks')[$key];

            $questionData = [
                'question_set_id' => $questionSetId,
                'question_content' => $content,
                'question_type' => $questionType,
                'marks' => $marks,
            ];


            if ($questionType === 'mcq') {
                $questionData['option1'] = $request->input('option1')[$key];
                $questionData['option2'] = $request->input('option2')[$key];
                $questionData['option3'] = $request->input('option3')[$key];
                $questionData['option4'] = $request->input('option4')[$key];
                $questionData['correct_answer'] = $request->input('correct_answer')[$key];
            } elseif ($questionType === 'true_false') {
                $questionData['correct_answer'] = $request->input('correct_answer')[$key];
            }

            // Create the computer test question
            ComputerTestQuestion::create($questionData);
        }
    }
}
