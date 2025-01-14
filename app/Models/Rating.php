<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'review_id', 'rated_by', 'rating',
    ];

    // Relationships

    // The review that was rated
    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    // The user who gave the rating
    public function rater()
    {
        return $this->belongsTo(User::class, 'rated_by');
    }
}
