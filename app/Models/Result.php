<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable =['bpid',	'exam_id',	'total_marks',	'obtained_marks',	'staus',	'exam_config_id'	];
    public function member(){
        return $this->belongsTo(Member::class,'bpid','bpid');
    }
}
