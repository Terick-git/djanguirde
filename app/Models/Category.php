<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'color', 'icon'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    // Accessor pour le nombre de cours publiés
    public function getPublishedCoursesCountAttribute()
    {
        return $this->courses()->where('status', 'published')->count();
    }

    // Pour la compatibilité avec l'ancien code
    public function getCoursesCountAttribute()
    {
        return $this->published_courses_count;
    }
}