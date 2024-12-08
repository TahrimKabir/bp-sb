<?php

namespace App\Http\Controllers;

use App\Models\TypingTestQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypingTestController extends Controller
{
    public function showQuestionList()
    {
        $questionList = [];
        return view('typingTest.question-list-page', compact('questionList'));
    }

    public function showQuestionListChunk(Request $request)
    {
        // Extract the DataTable parameters
        $start = $request->input('start', 0); // Starting row
        $length = $request->input('length', 10); // Number of rows to fetch
        $searchValue = $request->input('search.value'); // Search value (if any)
        $orderColumnIndex = $request->input('order.0.column'); // Column index for sorting
        $orderDirection = $request->input('order.0.dir', 'asc'); // Sorting direction

        // Define sortable columns
        $columns = ['question_id', 'content', 'time_in_seconds']; // Adjust column names to match your table
        $orderColumn = $columns[$orderColumnIndex] ?? 'question_id';

        // Query the database
        $query = TypingTestQuestion::query();

        // Apply search filter
        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('content', 'like', "%$searchValue%")
                  ->orWhere('time_in_seconds', 'like', "%$searchValue%");
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
            $item->action = view('partials.question-actions', ['question' => $item])->render();
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
