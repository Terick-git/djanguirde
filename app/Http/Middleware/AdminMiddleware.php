<?php

namespace App\Http\Middleware; // <-- DOIT ÊTRE EXACTEMENT CELA

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware // <-- DOIT ÊTRE EXACTEMENT CELA
{
    /**
     * Gère la requête entrante.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Vérification de l'authentification (si non, redirige vers la page de connexion)
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // 2. Vérification si l'utilisateur est Admin 
        if (!$user->isAdmin()) {
            // L'utilisateur n'est pas Admin, redirection basée sur son vrai rôle
            if ($user->isTeacher()) {
                return redirect()->route('teacher.dashboard');
            }
            // Par défaut, si ce n'est ni Admin ni Teacher, c'est un Student
            return redirect()->route('student.dashboard');
        }

        // L'utilisateur est Admin, il peut continuer
        return $next($request);
    }
}
