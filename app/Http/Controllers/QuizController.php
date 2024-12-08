<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;

class QuizController extends Controller
{

    public function createQuestion(){
        $courses=Course::with('lessons')->where('status',['active'])->get();
        return view('course.quiz.add-quiz-question-page',compact('courses'));
    }
    public function storeQuestion(Request $request){
        $validate=$request->validate([
            'question'=>'required|string|max:255',
            'a'=>'required|string|max:255',
            'b'=>'required|string|max:255',
            'c'=>'required|string|max:255',
            'd'=>'required|string|max:255',
            'answer'=>'required|in:a,b,c,d',
            'course_id'=>'required',
            'lesson_id'=> 'required'

        ]);

        QuizQuestion::create([
            'question'=>$request->question,
            'a'=>$request->a,
            'b'=>$request->b,
            'c'=>$request->c,
            'd'=>$request->d,
            'answer'=>$request->answer,
            'course_id'=>$request->course_id,
            'lesson_id'=> $request->lesson_id
        ]);

        return back()->with('success','Question added successfully');
    }

    public function quizQuestionList()
    {
        $quizQuestions = [];
        return view('course.quiz.quiz-question-list', compact('quizQuestions'));
    }

    public function quizQuestionListChunk(Request $request)
    {
        // Extract the DataTable parameters
        $start = $request->input('start', 0); // Starting row
        $length = $request->input('length', 10); // Number of rows to fetch
        $searchValue = $request->input('search.value'); // Search value (if any)
        $orderColumnIndex = $request->input('order.0.column'); // Column index for sorting
        $orderDirection = $request->input('order.0.dir', 'asc'); // Sorting direction

        // Define sortable columns
        $columns = ['question_id', 'lesson_id', 'course_id', 'question', 'a', 'b', 'c', 'd', 'answer'];
        $orderColumn = $columns[$orderColumnIndex] ?? 'question_id';

        // Query the database
        $query = QuizQuestion::query();

        // Apply search filter
        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('question', 'like', "%$searchValue%")
                  ->orWhere('a', 'like', "%$searchValue%")
                  ->orWhere('b', 'like', "%$searchValue%")
                  ->orWhere('c', 'like', "%$searchValue%")
                  ->orWhere('d', 'like', "%$searchValue%")
                  ->orWhere('answer', 'like', "%$searchValue%");
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
            $item->answer == 'a' ? $item->a = '<div class="text-center clr-dark-green">' . $item->a .'</div>' : '';
            $item->answer == 'b' ? $item->b = '<div class="text-center clr-dark-green">' . $item->b .'</div>' : '';
            $item->answer == 'c' ? $item->c = '<div class="text-center clr-dark-green">' . $item->c .'</div>' : '';
            $item->answer == 'd' ? $item->d = '<div class="text-center clr-dark-green">' . $item->d .'</div>' : '';

            $item->course_title = @$item->course->title;
            $item->lesson_title = @$item->lesson->title;

            $item->action = '<div class="col-12 d-flex justify-content-center">
                                    <button type="button" class="btn btn-danger btn-xs" onclick="confirmDelete(' . $item->question_id . ')">
                                        Delete
                                    </button>
                                    <a href="' . url('admin/edit-quiz-question/' . $item->question_id) . '" class="btn btn-warning btn-xs ml-1">
                                        Edit
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

    public function editQuizQuestion($id)
    {
        $question=QuizQuestion::where('question_id',$id)->with('course')->first();
        $courses=Course::with('lessons')->where('status',['active'])->get();

        return view('course.quiz.edit-quiz-question-page',compact('question','courses'));
    }

   public function updateQuizQuestion(Request $request,$id){

        $validated=$request->validate([
            'question'=>'required|string|max:255',
            'a'=>'required|string|max:255',
            'b'=>'required|string|max:255',
            'c'=>'required|string|max:255',
            'd'=>'required|string|max:255',
            'answer'=>'required|in:a,b,c,d',
            'course_id'=>'required',
            'lesson_id'=> 'required'

        ]);

       $question=QuizQuestion::findOrFail($id);

        $question->update($validated);
        return back()->with('success','Question updated successfully');


}

public  function deleteQuizQuestion($id){
        $question=QuizQuestion::findOrFail($id);
        $question->delete();

        return back()->with('success','Question Deleted Successfully');

}




}
