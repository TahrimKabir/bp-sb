<?php

namespace App\Http\Controllers;

use App\Models\Mcq_question;
use Illuminate\Http\Request;

class QuestionListController extends Controller
{
    public function index()
    {
        // $question = Mcq_question::all();
        $question = [];
        return view('iqTest.question-list', compact('question'));
    }
    
    public function indexList(Request $request)
    {
        // Extract the DataTable parameters
        $start = $request->input('start', 0); // Starting row
        $length = $request->input('length', 10); // Number of rows to fetch
        $searchValue = $request->input('search.value'); // Search value (if any)
        $orderColumnIndex = $request->input('order.0.column'); // Column index for sorting
        $orderDirection = $request->input('order.0.dir', 'asc'); // Sorting direction

        // Define sortable columns
        $columns = ['question_id', 'question', 'option1', 'option2', 'option3', 'option4', 'option5', 'option6', 'correct_option']; // Adjust column names to match your table
        $orderColumn = $columns[$orderColumnIndex] ?? 'question_id';

        // Query the database
        $query = Mcq_question::query();

        // Apply search filter
        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('question', 'like', "%$searchValue%")
                  ->orWhere('option1', 'like', "%$searchValue%")
                  ->orWhere('option2', 'like', "%$searchValue%")
                  ->orWhere('option3', 'like', "%$searchValue%")
                  ->orWhere('option4', 'like', "%$searchValue%")
                  ->orWhere('option5', 'like', "%$searchValue%")
                  ->orWhere('option6', 'like', "%$searchValue%")
                  ->orWhere('correct_option', 'like', "%$searchValue%");
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
            $item->correct_option == 1 ? $item->option1 = '<div class="text-center clr-dark-green">' . $item->option1 .'</div>' : '';
            $item->correct_option == 2 ? $item->option2 = '<div class="text-center clr-dark-green">' . $item->option2 .'</div>' : '';
            $item->correct_option == 3 ? $item->option3 = '<div class="text-center clr-dark-green">' . $item->option3 .'</div>' : '';
            $item->correct_option == 4 ? $item->option4 = '<div class="text-center clr-dark-green">' . $item->option4 .'</div>' : '';
            $item->correct_option == 5 ? $item->option5 = '<div class="text-center clr-dark-green">' . $item->option5 .'</div>' : '';
            $item->correct_option == 6 ? $item->option6 = '<div class="text-center clr-dark-green">' . $item->option6 .'</div>' : '';

            $item->action = '<div class="col-12 d-flex justify-content-center py-2">
                                                <a href="' . url('/delete/question/'.$item->question_id) .'" class="btn btn-xs btn-danger">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                                        <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5zm13-3H1v2h14zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                                                      </svg>
                                                </a>
                                                <a href="' . url('/edit/question/'.$item->question_id) . '" class="btn btn-warning btn-xs ml-1">
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

    public function edit($id)
    {
        $question = Mcq_question::where('question_id', $id)->first();
        return view('iqTest.edit-question', compact('question'));
    }

    public function update(Request $req)
    {
        $data = array('question' => $req->question, 'correct_option' => $req->ans, 'option1' => $req->a, 'option2' => $req->b, 'option3' => $req->c, 'option4' => $req->d,'option5'=>$req->e,'option6'=>$req->f);

        Mcq_question::where('question_id', $req->cid)->update($data);
        return redirect()->back()->with('success','successfully updated');
    }
    public function delete($id){
        Mcq_question::where('question_id',$id)->delete();
        return redirect()->back()->with('success','!!record deleted!!');
    }

}
