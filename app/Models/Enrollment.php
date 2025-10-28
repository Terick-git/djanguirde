<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'course_id',
        'progress',
        'completed_lessons',
        'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'completed_lessons' => 'array', // ← AJOUTER CETTE LIGNE
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}