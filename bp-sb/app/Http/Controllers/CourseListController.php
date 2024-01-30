<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
class CourseListController extends Controller
{
    public function index(){
        $course = Course::all();
        return view('course-list',compact('course'));
    }
}
