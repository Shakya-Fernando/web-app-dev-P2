<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        's_number',
        'password',
        'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Relationships

    // Courses the user is enrolled in or teaching
    public function courses()
    {
        return $this->belongsToMany(Course::class)->withPivot('role')->withTimestamps();
    }

    // Reviews the user has submitted
    public function submittedReviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    // Reviews the user has received
    public function receivedReviews()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    // Ratings given by the user
    public function ratingsGiven()
    {
        return $this->hasMany(Rating::class, 'rated_by');
    }

    // Scores received by the student
    public function scores()
    {
        return $this->hasMany(Score::class, 'student_id');
    }
}
