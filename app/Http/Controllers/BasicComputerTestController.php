<?php

namespace App\Http\Controllers;

use App\Models\BasicComputerTestQuestion;
use App\Models\BasicComputerTestResult;
use App\Models\Exam_Schedule as ExamSchedule;
use App\Models\QuestionSet;
use App\Models\TypingTestQuestion;
use Illuminate\Http\Request;

class BasicComputerTestController extends Controller
{


    public function showQuestionSetList()
    {
        $questionSets = QuestionSet::where('type', 'basic')->get();
        return view('computerTest.basic.question-list-page', compact('questionSets'));
    }
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

    public function mcqQuestionList() {
        $mcqQuestions = BasicComputerTestQuestion::where('question_type', 'mcq')->get();
        return view('computerTest.basic.mcq-question-list-page', compact('mcqQuestions'));
    }

    public function mcqQuestionDelete($question_id)
    {
        BasicComputerTestQuestion::where('question_id',$question_id)->delete();

        // Redirect or return a response as needed
        return redirect()->back()->with('success', 'Question deleted successfully');
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

    public function trueFalseQuestionList() {
        $truFalseQuestions = BasicComputerTestQuestion::where('question_type', 'true_false')->get();
        return view('computerTest.basic.true-false-question-list-page', compact('truFalseQuestions'));
    }

    public function trueFalseQuestionDelete($question_id)
    {
        BasicComputerTestQuestion::where('question_id',$question_id)->delete();

        // Redirect or return a response as needed
        return redirect()->back()->with('success', 'Question deleted successfully');
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

    public function showResult($examScheduleId)
    {
        $examSchedule = ExamSchedule::with(['config.exam', 'member'])->findOrFail($examScheduleId);
        $result = BasicComputerTestResult::where('exam_schedule_id', $examScheduleId)->first();;

        $mcqQuestions = BasicComputerTestQuestion::whereIn('question_id', array_keys($result->result_data['mcq'] ?? []))->get();
        $trueFalseQuestions = BasicComputerTestQuestion::whereIn('question_id', array_keys($result->result_data['true_false'] ?? []))->get();
        $typingTestQuestions = TypingTestQuestion::whereIn('question_id', array_keys($result->result_data['typing_test'] ?? []))->get();


        return view('computerTest.basic.result-page', compact('result', 'mcqQuestions', 'trueFalseQuestions', 'typingTestQuestions','examSchedule'));
    }
    //
}
