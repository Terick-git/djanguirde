<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TeacherMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Debug: vérifiez le rôle
        \Log::info('User role: ' . $user->role);
        \Log::info('Is teacher: ' . ($user->isTeacher() ? 'true' : 'false'));

        if (!$user->isTeacher()) {
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('student.dashboard');
            }
        }

        return $next($request);
    }
}
