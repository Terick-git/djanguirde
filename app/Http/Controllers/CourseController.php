<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Récupérer les paramètres de filtrage
            $search = $request->query('search');
            $category = $request->query('category');
            $level = $request->query('level');

            // Construire la requête avec les filtres
            $coursesQuery = Course::with(['instructor', 'category', 'lessons'])
                ->withCount(['lessons', 'enrollments'])
                ->where('status', 'published');

            // Appliquer les filtres
            if ($search) {
                $coursesQuery->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%")
                          ->orWhere('short_description', 'like', "%{$search}%");
                });
            }

            if ($category) {
                $coursesQuery->whereHas('category', function ($query) use ($category) {
                    $query->where('slug', $category);
                });
            }

            if ($level) {
                $coursesQuery->where('level', $level);
            }

            $courses = $coursesQuery->orderBy('order')
                ->orderBy('created_at', 'desc')
                ->get();

            // Récupérer les catégories avec le nombre de cours publiés
            $categories = Category::withCount(['courses' => function ($query) {
                $query->where('status', 'published');
            }])->get();

            Log::info('CourseController - Cours trouvés: ' . $courses->count());
            Log::info('CourseController - Catégories: ' . $categories->count());

            return Inertia::render('Courses/Index', [
                'courses' => $courses,
                'categories' => $categories,
                'filters' => [
                    'search' => $search,
                    'category' => $category,
                    'level' => $level
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur CourseController@index: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return Inertia::render('Courses/Index', [
                'courses' => [],
                'categories' => [],
                'filters' => [],
            ]);
        }
    }

    public function show(Course $course)
    {
        try {
            // Vérifier que le cours est publié
            if ($course->status !== 'published') {
                abort(404);
            }

            $course->load(['instructor', 'category', 'lessons' => function ($query) {
                $query->orderBy('order');
            }]);
            
            $course->loadCount(['lessons', 'enrollments']);

            $user = Auth::user();
            $hasEnrolled = $user ? $user->enrollments()->where('course_id', $course->id)->exists() : false;

            // Cours similaires
            $relatedCourses = Course::where('category_id', $course->category_id)
                ->where('id', '!=', $course->id)
                ->where('status', 'published')
                ->with(['instructor', 'category'])
                ->withCount(['lessons', 'enrollments'])
                ->limit(4)
                ->get();

            return Inertia::render('Courses/Show', [
                'course' => $course,
                'hasEnrolled' => $hasEnrolled,
                'relatedCourses' => $relatedCourses,
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur CourseController@show: ' . $e->getMessage());
            abort(404, 'Cours non trouvé');
        }
    }

    public function byCategory(Category $category)
    {
        try {
            $courses = $category->courses()
                ->with(['instructor', 'category'])
                ->withCount(['lessons', 'enrollments'])
                ->where('status', 'published')
                ->orderBy('order')
                ->orderBy('created_at', 'desc')
                ->get();

            return Inertia::render('Courses/Category', [
                'category' => $category,
                'courses' => $courses
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur CourseController@byCategory: ' . $e->getMessage());
            abort(404);
        }
    }
}