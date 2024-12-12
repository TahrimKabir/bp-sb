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
        $questionSets = [];
        return view('computerTest.basic.question-list-page', compact('questionSets'));
    }

    public function showQuestionSetListChunk(Request $request)
    {
        // Extract the DataTable parameters
        $start = $request->input('start', 0); // Starting row
        $length = $request->input('length', 10); // Number of rows to fetch
        $searchValue = $request->input('search.value'); // Search value (if any)
        $orderColumnIndex = $request->input('order.0.column'); // Column index for sorting
        $orderDirection = $request->input('order.0.dir', 'asc'); // Sorting direction
        // Define sortable columns
        $columns = ['question_set_id', 'question_set_name', 'num_of_mcq', 'num_of_true_false', 'num_of_typing_test'];
        $orderColumn = $columns[$orderColumnIndex] ?? 'id';
        // Query the database
        $query = QuestionSet::query();
        $query->where('type', 'basic');
        // Apply search filter
        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('question_set_name', 'like', "%$searchValue%")
                    ->orWhere('num_of_mcq', 'like', "%$searchValue%")
                    ->orWhere('num_of_true_false', 'like', "%$searchValue%")
                    ->orWhere('num_of_typing_test', 'like', "%$searchValue%");
            });
        }
        // Get total count before applying pagination
        $totalRecords = $query->count();
        // Apply sorting and pagination
        $data = $query->orderBy($orderColumn, $orderDirection)
            ->skip($start)
            ->take($length)
            ->get();

        // Append action column
        $data->transform(function ($item, $index) use ($start) {
            $item->serial = $start + $index + 1;
            return $item;
        });
        // Return response in DataTable-compatible format
        return response()->json([
            'draw' => $request->input('draw'), // Pass through DataTables draw parameter
            'recordsTotal' => $totalRecords, // Total records without filtering
            'recordsFiltered' => $totalRecords, // Total records after filtering
            'data' => $data, // Paginated data
        ]);
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

    public function editMcqQuestion($id)
    {
        // Fetch the question by ID
        $question = BasicComputerTestQuestion::findOrFail($id);

        // Pass the question to the view
        return view('computerTest.basic.edit-mcq-question', compact('question'));
    }

    public function updateMcqQuestion(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'question_content' => 'required|string|max:255',
            'option1' => 'required|string|max:255',
            'option2' => 'required|string|max:255',
            'option3' => 'required|string|max:255',
            'option4' => 'required|string|max:255',
            'correct_answer' => 'required|in:1,2,3,4',
        ]);

        // Fetch the question
        $question = BasicComputerTestQuestion::findOrFail($id);

        // Update the question data
        $question->question_content = $request->question_content;
        $question->option1 = $request->option1;
        $question->option2 = $request->option2;
        $question->option3 = $request->option3;
        $question->option4 = $request->option4;
        $question->correct_answer = $request->correct_answer;

        // Save the updated question
        if ($question->save()) {
            return redirect()->to('/computer-test/basic/mcq-question-list')->with('success', 'Question updated successfully!');

        }

        return back()->with('fail', 'Failed to update the question.');
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

    public function editTrueFalseQuestion($question_id)
    {
        // Find the question by its ID
        $question = BasicComputerTestQuestion::findOrFail($question_id);

        // Return the edit view with the question data
        return view('computerTest.basic.edit-true-false-question', compact('question'));
    }
    public function updateTrueFalseQuestion(Request $request, $question_id)
    {
        // Validate the incoming request
        $request->validate([
            'question_content' => 'required|string|max:255',
            'correct_answer' => 'required|string|max:255',
        ]);

        // Find the question by its ID
        $question = BasicComputerTestQuestion::findOrFail($question_id);

        // Update the question with the new data
        $question->update([
            'question_content' => $request->input('question_content'),
            'correct_answer' => $request->input('correct_answer'),
        ]);


            return redirect()->to('computer-test/basic/true-false-question-list')->with('success', 'Question updated successfully!');


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

    public function editQuestionSet($id)
    {
        // Find the QuestionSet by ID
        $questionSet = QuestionSet::findOrFail($id);
        $totalMcqQuestions = BasicComputerTestQuestion::where('question_type', 'mcq')->count();
        $totalTrueFalseQuestions = BasicComputerTestQuestion::where('question_type', 'true_false')->count();
        $totalTypingTestQuestions = TypingTestQuestion::count();

        return view('computerTest.basic.question-set-edit', compact('questionSet','totalMcqQuestions', 'totalTrueFalseQuestions', 'totalTypingTestQuestions'));
    }

    public function updateQuestionSet(Request $request, $id)
    {
        // Find the existing question set
        $questionSet = QuestionSet::findOrFail($id);

        // Validate the request
        $request->validate([
            'question_set_name' => 'required|string',
            'num_of_mcq' => 'required|integer|min:1',
            'num_of_true_false' => 'required|integer|min:1',
            'num_of_typing_test' => 'required|integer|min:1',
        ]);

        // Update the question set
        $questionSet->update($request->all());

        // Redirect back with success message
        return redirect()->to('/computer-test/basic/question-set-list')->with('success', 'Question Set updated successfully!');
    }


    public function deleteQuestionSet($id)
    {
        try {
            $questionSet = QuestionSet::findOrFail($id);
            $questionSet->delete();

            return response()->json(['success' => 'Question set deleted successfully!']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
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
