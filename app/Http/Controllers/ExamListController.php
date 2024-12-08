<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamListController extends Controller
{
    public function index()
    {
        $exam = [];
        return view('exam-list', compact('exam'));
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
        $columns = ['exam_id', 'exam_name', 'details', 'type'];
        $orderColumn = $columns[$orderColumnIndex] ?? 'exam_id';

        // Query the database
        $query = Exam::query();

        // Apply search filter
        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('exam_name', 'like', "%$searchValue%")
                  ->orWhere('details', 'like', "%$searchValue%")
                  ->orWhere('type', 'like', "%$searchValue%");
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
            $item->action = '<div class="col-12 d-flex justify-content-center">
                                <a href="' . asset('/delete/exam/'.$item->exam_id) .'" class="btn btn-xs btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                        <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5zm13-3H1v2h14zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                                        </svg>
                                </a>
                                <a href="' . asset('/edit/exam/'.$item->exam_id) . '" class="btn btn-warning btn-xs ml-1">
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

        $exam = Exam::where('exam_id', $id)->first();
        $course = Course::all();
        return view('edit-exam', compact('course', 'exam'));
    }
    public function update(Request $req)
    {
        // || $req->course_id == null may come later
        if ($req->exam == null  || $req->details == null || $req->type==null) {
            return redirect()->back()->with('fail', 'Exam details/exam-title/course/type must be filled');
        } else {
            $check = Exam::where('exam_name', $req->exam)->where('type', $req->type)->get();
            if (count($check) == 0) {
                $data = array('exam_name' => $req->exam, 'type' => $req->type, 'details' => $req->details, 'status' => 'deactive');
                Exam::where('exam_id', $req->id)->update($data);
                return redirect()->back()->with('success', 'Exam updated successfully');
            } else {
                return redirect()->back()->with('fail', 'could not update!');
            }
        }

    }

    public function delete($id)
    {
        Exam::where('exam_id', $id)->delete();
        return redirect()->back()->with('fail', 'Exam deleted successfully');
    }
}
