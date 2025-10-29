<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Vérifiez que l'utilisateur est bien un enseignant
        if (!$user->isTeacher()) {
            abort(403, 'Accès non autorisé');
        }

        $stats = [
            'totalCourses' => 0,
            'totalStudents' => 0,
            'revenue' => 0,
            'averageRating' => 0,
        ];

        return Inertia::render('Teacher/Dashboard', [
            'user' => $user,
            'stats' => $stats,
        ]);
    }

    public function myCourses()
    {
        return Inertia::render('Teacher/Courses/Index');
    }

    public function createCourse()
    {
        return Inertia::render('Teacher/Courses/Create');
    }

    public function myStudents()
    {
        return Inertia::render('Teacher/Students/Index');
    }

    public function analytics()
    {
        return Inertia::render('Teacher/Analytics/Index');
    }
}
