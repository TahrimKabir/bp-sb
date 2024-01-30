<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam_credential extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['mcstatus_id','pin_number','start','is_finished'];
}
