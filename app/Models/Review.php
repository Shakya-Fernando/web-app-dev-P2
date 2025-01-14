<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'assessment_id', 'reviewer_id', 'reviewee_id', 'content',
    ];

    // Relationships

    // The assessment this review belongs to
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    // The user who wrote the review
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    // The user who received the review
    public function reviewee()
    {
        return $this->belongsTo(User::class, 'reviewee_id');
    }

    // Ratings for this review
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
