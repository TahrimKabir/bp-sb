<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    // Define the table name if it's different from the default 'lessons'
    protected $table = 'lessons';

    // Define the primary key column name
    protected $primaryKey = 'id_lessons';

    // Specify the columns that can be mass assigned
    protected $fillable = [
        'courses_id',
        'title',
        'content',
        'lesson_no',
        'created_at',
        'quiz_status',
        'quiz_mark',
    ];

    // Define the relationship between lessons and courses (Many-to-One)
    public function course()
    {
        return $this->belongsTo(Course::class, 'courses_id', 'id_courses');
    }
}
