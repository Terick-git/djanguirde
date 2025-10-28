<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description', 
        'short_description',
        'thumbnail',
        'price',
        'level',
        'status',
        'instructor_id',
        'category_id',
        'duration',
        'video_count',
        'view_count',
        'rating',
        'order',
        'objectives',
        'requirements'
    ];

    protected $casts = [
        'objectives' => 'array',
        'requirements' => 'array',
        'price' => 'decimal:2',
        'rating' => 'decimal:2'
    ];

    // AJOUT: Propriétés à compter
    protected $withCount = ['lessons', 'enrollments'];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Accessor pour la durée formatée
    public function getFormattedDurationAttribute()
    {
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;
        
        if ($hours > 0) {
            return "{$hours}h {$minutes}min";
        }
        
        return "{$minutes}min";
    }

    // Accessor pour les vues formatées
    public function getFormattedViewsAttribute()
    {
        if ($this->view_count >= 1000) {
            return number_format($this->view_count / 1000, 1) . ' k';
        }
        
        return $this->view_count;
    }

    // Accessor pour le prix formaté
    public function getFormattedPriceAttribute()
    {
        if ($this->price == 0) {
            return 'Gratuit';
        }
        
        return number_format($this->price, 2) . ' €';
    }

    // Vérifier si le cours est gratuit
    public function getIsFreeAttribute()
    {
        return $this->price == 0;
    }
}