<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['course_id','qus_cat','ques_type','question','a','b','c','d','answer','ans'];
}
