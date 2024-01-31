<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['exam_id','exam_name','course_id','type','details','status'];
}
