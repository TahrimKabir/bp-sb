<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
        'bpid',
        'name',
        'designation',
        'post',
        'posting_area',
        'mobile',
        'dob',
        'joining_date',
    ];
    public function schedule(){
        return $this->hasMany(Exam_Schedule::class,'bpid','bpid');
    }

    public function result(){
        return $this->hasMany(Result::class,'bpid','bpid');
    }
}
