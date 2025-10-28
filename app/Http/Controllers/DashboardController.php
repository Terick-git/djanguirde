<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Cours auxquels l'utilisateur est inscrit
        $enrolledCourses = $user->courses()
            ->withCount('lessons')
            ->get()
            ->map(function ($course) use ($user) {
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'slug' => $course->slug,
                    'description' => $course->description,
                    'lessons_count' => $course->lessons_count,
                    'pivot' => [
                        'progress' => $course->pivot->progress ?? 0,
                    ]
                ];
            });

        // Cours recommandés (exemple : cours non inscrits)
        $recommendedCourses = Course::whereNotIn('id', $enrolledCourses->pluck('id'))
            ->withCount('lessons')
            ->limit(4)
            ->get()
            ->map(function ($course) {
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'slug' => $course->slug,
                    'description' => $course->description,
                    'lessons_count' => $course->lessons_count,
                ];
            });

        return Inertia::render('Dashboard', [
            'enrolledCourses' => $enrolledCourses,
            'recommendedCourses' => $recommendedCourses,
            'stats' => [
                'total_courses' => $enrolledCourses->count(),
                'total_lessons' => 12, // À calculer dynamiquement
                'study_time' => '8h 30min',
                'average_progress' => 45,
            ]
        ]);
    }
}
