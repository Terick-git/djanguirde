<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('Admin/Dashboard');
    }

    public function users()
    {
        return Inertia::render('Admin/Users/Index');
    }

    public function courses()
    {
        return Inertia::render('Admin/Courses/Index');
    }

    public function settings()
    {
        return Inertia::render('Admin/Settings/Index');
    }
}
