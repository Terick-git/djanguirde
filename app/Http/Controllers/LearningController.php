<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

/**
 * Controller pour la gestion de l'apprentissage
 * 
 * @package App\Http\Controllers
 */
class LearningController extends Controller
{
    /**
     * Afficher la page d'apprentissage d'un cours
     */
    public function show(Course $course)
    {
        // RÉSOLUTION : Récupérer l'utilisateur via Auth::user() au lieu de auth()->user()
        $user = Auth::user();
        
        // Vérifier si l'utilisateur existe ET est inscrit au cours
        if (!$user || !$user->hasEnrolled($course)) {
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Vous devez vous inscrire à ce cours pour y accéder.');
        }

        // Charger les relations du cours
        $course->load(['lessons' => function ($query) {
            $query->orderBy('order');
        }, 'instructor', 'category']);

        // RÉSOLUTION : Utiliser $user->id au lieu de auth()->id()
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        $completedLessons = $enrollment->completed_lessons ?? [];

        return Inertia::render('Learning/Course', [
            'course' => $course,
            'enrollment' => $enrollment,
            'completedLessons' => $completedLessons,
            'currentLesson' => $course->lessons->first(),
        ]);
    }

    /**
     * Afficher une leçon spécifique
     */
    public function lesson(Course $course, Lesson $lesson)
    {
        // RÉSOLUTION : Récupérer l'utilisateur via Auth::user()
        $user = Auth::user();
        
        if (!$user || !$user->hasEnrolled($course)) {
            abort(403, 'Accès non autorisé');
        }

        $course->load(['lessons' => function ($query) {
            $query->orderBy('order');
        }]);

        // RÉSOLUTION : Utiliser $user->id
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        $completedLessons = $enrollment->completed_lessons ?? [];

        // Trouver la leçon précédente et suivante
        $currentIndex = $course->lessons->search(function ($item) use ($lesson) {
            return $item->id === $lesson->id;
        });

        $previousLesson = $currentIndex > 0 ? $course->lessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < $course->lessons->count() - 1 ? $course->lessons[$currentIndex + 1] : null;

        return Inertia::render('Learning/Lesson', [
            'course' => $course,
            'lesson' => $lesson,
            'enrollment' => $enrollment,
            'completedLessons' => $completedLessons,
            'previousLesson' => $previousLesson,
            'nextLesson' => $nextLesson,
            'currentIndex' => $currentIndex,
            'totalLessons' => $course->lessons->count(),
        ]);
    }

    /**
     * Marquer une leçon comme terminée
     */
    public function completeLesson(Course $course, Lesson $lesson, Request $request)
    {
        // RÉSOLUTION : Récupérer l'utilisateur via Auth::user()
        $user = Auth::user();
        
        if (!$user || !$user->hasEnrolled($course)) {
            abort(403, 'Accès non autorisé');
        }

        // RÉSOLUTION : Utiliser $user->id
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        // Marquer la leçon comme complétée
        $completedLessons = $enrollment->completed_lessons ?? [];
        if (!in_array($lesson->id, $completedLessons)) {
            $completedLessons[] = $lesson->id;
        }

        // Calculer la progression
        $progress = (count($completedLessons) / $course->lessons->count()) * 100;

        $enrollment->update([
            'completed_lessons' => $completedLessons,
            'progress' => $progress,
            'completed_at' => $progress >= 100 ? now() : null,
        ]);

        return response()->json([
            'success' => true,
            'progress' => $progress,
            'completed_lessons' => $completedLessons,
        ]);
    }

    /**
     * Inscrire un utilisateur à un cours
     */
    public function enroll(Course $course, Request $request)
    {
        // RÉSOLUTION : Utiliser Auth::user()
        $user = Auth::user();

        if ($user->hasEnrolled($course)) {
            return redirect()->route('learning.course', $course->slug);
        }

        // Créer l'inscription
        Enrollment::create([
            'user_id' => $user->id, // RÉSOLUTION : Utiliser $user->id
            'course_id' => $course->id,
            'progress' => 0,
            'completed_lessons' => [],
        ]);

        return redirect()->route('learning.course', $course->slug)
            ->with('success', 'Vous êtes maintenant inscrit à ce cours !');
    }
}