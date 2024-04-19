<?php

namespace App\Http\Controllers;

use App\Models\BasicComputerTestQuestion;
use App\Models\QuestionSet;
use App\Models\TypingTestQuestion;
use Illuminate\Http\Request;

class BasicComputerTestController extends Controller
{
    public function createMcqQuestion(){
        return view('computerTest.basic.create-mcq-question-page');
    }

    public function createTrueFalseQuestion(){
        return view('computerTest.basic.create-true-false-question-page');
    }

    public function storeMcqQuestion(Request $request){
        $validatedData = $request->validate([
            'question_content' => 'required',
            'option1' => 'required',
            'option2' => 'required',
            'option3' => 'required',
            'option4' => 'required',
            'correct_answer' => 'required',

        ]);


        $validatedData['question_type'] = 'mcq';

        // Create a new member and store it in the database
        BasicComputerTestQuestion::create($validatedData);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Question added successfully.');

    }

public function storeTrueFalseQuestion(Request $request){
    $validatedData = $request->validate([
        'question_content' => 'required',
        'correct_answer' => 'required',

    ]);


    $validatedData['question_type'] = 'true_false';

    // Create a new member and store it in the database
    BasicComputerTestQuestion::create($validatedData);

    // Redirect back with success message
    return redirect()->back()->with('success', 'Question added successfully.');


}

public function createQuestionSet(){
    $totalMcqQuestions = BasicComputerTestQuestion::where('question_type', 'mcq')->count();
    $totalTrueFalseQuestions = BasicComputerTestQuestion::where('question_type', 'true_false')->count();
    $totalTypingTestQuestions = TypingTestQuestion::count();

    return view('computerTest.basic.create-question-set-page', compact('totalMcqQuestions', 'totalTrueFalseQuestions', 'totalTypingTestQuestions'));

}



    public function storeQuestionSet(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'question_set_name' => 'required|string',
            'num_of_mcq' => 'required|integer|min:1',
            'num_of_true_false' => 'required|integer|min:1',
            'num_of_typing_test' => 'required|integer|min:1',
        ]);
        $validatedData['type']='basic';

        // Create a new instance of the BasicComputerTestQuestionSet model and save it to the database
        $questionSet = QuestionSet::create($validatedData);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Question set created successfully.');
    }

    //
}
