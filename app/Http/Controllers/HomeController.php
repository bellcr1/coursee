<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $userCount = User::where('role', 'users')->count();
        $coachCount = User::where('role', 'coach')->count();
        $courseCount = Course::count();
        $categories = Category::all(); 
        $courses= Course::all();
        return view('home', compact('userCount','coachCount','courseCount','categories','courses'));


    }

    public function count(): void{
       
        }

        public function about()
        {
            $userCount = User::where('role', 'users')->count();
            $coachCount = User::where('role', 'coach')->count();
            $courseCount = Course::count();
            return view('about',compact('userCount','coachCount','courseCount'));
        }
}
