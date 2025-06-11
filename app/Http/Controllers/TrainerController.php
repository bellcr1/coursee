<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index()
    {
        $categories = Category::all(); 
        $coaches = User::where('role', 'coach')->get();
        return view('trainers', compact('coaches', 'categories'));
    }

    public function show($id)
    {
        $users = User::findOrFail($id);
        $namecat = Category::find($users->category);
        return view('coachprofile', compact('users', 'namecat'));
    }
}