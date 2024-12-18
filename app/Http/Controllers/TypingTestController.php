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
            $item->action = '<div class="col-12 d-flex justify-content-center py-2">
                                <a href="' . url('/delete-typing-test-question/'.$item->question_id) .'" class="btn btn-xs btn-danger" onclick="return confirm(\'Are you sure you want to delete?\');">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                        <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5zm13-3H1v2h14zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                                        </svg>
                                </a>
                                <a href="' . url('/edit-typing-test-question/'.$item->question_id) . '" class="btn btn-warning btn-xs ml-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                        </svg>
                                </a>
                                </div>';

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
