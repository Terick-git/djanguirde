<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('Student/Dashboard');
    }

    public function myCourses()
    {
        return Inertia::render('Student/Courses/Index');
    }

    public function progress()
    {
        return Inertia::render('Student/Progress/Index');
    }

    public function profile()
    {
        return Inertia::render('Student/Profile/Index');
    }
}
