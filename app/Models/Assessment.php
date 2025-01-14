<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'course_id', 'title', 'instruction', 'number_of_reviews', 'max_score', 'due_date', 'type',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];
    // Alternatively, for an  an older version of Laravel,we can use:
    // protected $dates = ['due_date'];

    // Relationships

    // The course this assessment belongs to
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Reviews for this assessment
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Scores for this assessment
    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
