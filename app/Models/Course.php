<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['course_id','course_title'];
    
    public function exam(){
        return $this->hasMany(Exam::class,'course_id','course_id');
    }
}
