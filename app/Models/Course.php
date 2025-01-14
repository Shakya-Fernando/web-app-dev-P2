<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'code', 'name',
    ];

    // Relationships

    // Users enrolled in or teaching the course
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('role')->withTimestamps();
    }

    // Assessments in the course
    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }
}
