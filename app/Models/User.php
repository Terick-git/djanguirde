<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'access_code',
    ];

    // ... reste du code avec requiresAccessCode()

    public function requiresAccessCode(): bool
    {
        return in_array($this->role, ['admin', 'instructor']);
    }
}
