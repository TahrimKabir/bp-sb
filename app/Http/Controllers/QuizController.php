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
        $quizQuestions = QuizQuestion::with('course')->with('lesson')->get();
        return view('course.quiz.quiz-question-list', compact('quizQuestions'));
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
