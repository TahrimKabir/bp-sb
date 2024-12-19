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
        $questionSets = [];
        return view('computerTest.advanced.question-list-page', compact('questionSets'));
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
        $columns = ['question_set_id', 'question_set_name'];
        $orderColumn = $columns[$orderColumnIndex] ?? 'id';

        // Query the database
        $query = QuestionSet::query();
        $query->where('type', 'advanced');

        // Apply search filter
        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('question_set_name', 'like', "%$searchValue%");
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
            $item->num_of_question = $item->questions->count();

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
        return view('computerTest.advanced.create-question-page');
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


        $this->processComputerTestQuestions($request, $questionSet->question_set_id);

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
