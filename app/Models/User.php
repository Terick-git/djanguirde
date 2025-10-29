<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Constantes de rôle
    const ROLE_STUDENT = 'student';
    const ROLE_TEACHER = 'teacher';
    const ROLE_ADMIN = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'access_code',
        'bio',
        'specialization',
        'phone',
        'settings',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'settings' => 'array',
            'last_login' => 'datetime',
        ];
    }

    // ==================== MÉTHODES DE RÔLE ====================
    
    public function isStudent(): bool
    {
        return $this->role === self::ROLE_STUDENT;
    }

    public function isTeacher(): bool
    {
        return $this->role === self::ROLE_TEACHER;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function requiresAccessCode(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_TEACHER]);
    }

    // ==================== RELATIONS ====================

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')
                    ->withPivot('progress', 'completed_at', 'rating')
                    ->withTimestamps();
    }

    public function createdCourses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            self::ROLE_STUDENT => 'Étudiant',
            self::ROLE_TEACHER => 'Enseignant',
            self::ROLE_ADMIN => 'Administrateur',
            default => 'Inconnu'
        };
    }
}