<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Check if the user is authenticated
        $user = Auth::user();

        if ($user) {
            if ($user->role == 'student') {
                $courses = $user->courses()->wherePivot('role', 'student')->get();
            } else {
                $courses = $user->courses()->wherePivot('role', 'teacher')->get();
            }
        } else {
            // Handle unauthenticated case, e.g., redirect to login or show a different view
            return redirect()->route('login');
        }

        return view('home', compact('courses'));
    }
}