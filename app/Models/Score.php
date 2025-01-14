<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'assessment_id', 'student_id', 'score',
    ];

    // Relationships

    // The assessment this score belongs to
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    // The student who received the score
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
