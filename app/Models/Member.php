<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    public function schedule(){
        return $this->hasMany(Exam_Schedule::class,'bpid','bpid');
    }
}
