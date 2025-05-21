<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::where('user_id', Auth::id())
            ->with('course')
            ->get();
            
        return view('favorite', ['favorites' => $favorites]);
    }

    public function toggle(Course $course)
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['status' => 'removed']);
        }

        Favorite::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id
        ]);

        return response()->json(['status' => 'added']);
    }
}