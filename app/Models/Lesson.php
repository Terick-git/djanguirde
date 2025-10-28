<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'video_url',
        'video_type', // ← AJOUTER CETTE LIGNE
        'duration',
        'order',
        'is_free',
        'course_id'
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'duration' => 'integer',
        'order' => 'integer',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Nouvelle méthode pour déterminer le type de vidéo
    public function getVideoTypeAttribute()
    {
        $url = $this->attributes['video_url'] ?? '';
        
        if (str_contains($url, 'vimeo.com')) {
            return 'vimeo';
        } elseif (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
            return 'youtube';
        } elseif (str_contains($url, '.mp4') || str_contains($url, '.webm') || str_contains($url, '.ogg')) {
            return 'html5';
        } else {
            return 'external';
        }
    }

    // Extraire l'ID Vimeo
    public function getVimeoIdAttribute()
    {
        if ($this->video_type === 'vimeo') {
            preg_match('/vimeo.com\/(\d+)/', $this->video_url, $matches);
            return $matches[1] ?? null;
        }
        return null;
    }

    // Extraire l'ID YouTube
    public function getYoutubeIdAttribute()
    {
        if ($this->video_type === 'youtube') {
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->video_url, $matches);
            return $matches[1] ?? null;
        }
        return null;
    }
}