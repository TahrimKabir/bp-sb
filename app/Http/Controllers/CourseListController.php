<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Mcq_question;
class CourseListController extends Controller
{
    public function index(){
        $course = Mcq_question::all();
        return view('course-list',compact('course'));
    }
}
