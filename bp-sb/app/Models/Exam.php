<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['exam_id','exam_name','course_id','type','details','status'];

    public function course(){
        return $this->belongsTo(Course::class,'course_id','course_id');
    }
    public function config(){
        return $this->hasMany(Exam_configuration::class,'exam_id','exam_id');
    }
}
