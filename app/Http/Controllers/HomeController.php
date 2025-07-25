<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Feedback;
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
        $categoryCount = Category::count();
        $categories = Category::all(); 
        $coachs = User::where('role', 'coach')->get();
        $courses= Course::orderByDesc('purchase_count')->take(3)->get();
        $feedbacks = Feedback::latest()->get(); 
        return view('home', compact('userCount','coachCount','courseCount','categories','courses','feedbacks','categoryCount','coachs'));


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
