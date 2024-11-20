<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;
    protected $primaryKey='question_id';
    protected $table='quiz_questions';
    protected $fillable=[
        'lesson_id',
        'course_id',
        'question',
        'a',
        'b',
        'c',
        'd',
        'answer'
    ];

    public function lesson(){
       return $this->belongsTo(Lesson::class,'lesson_id');
    }

    public function course(){
        return $this->belongsTo(Course::class,'course_id','id_courses');
    }
}
