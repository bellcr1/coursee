<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**test
     * Display percentage statistics dashboard
     */
    public function percentageStats()
    {
        // Get total counts
        $totalUsers = User::count();
        $totalCoaches = User::where('role', 'coach')->count();
        $totalCourses = Course::count();

        // Calculate percentages - adjust these max values according to your needs
        $maxExpectedUsers = 200;    // Example: You expect max 200 users
        $maxExpectedCoaches = 50;   // Example: Max 50 coaches expected
        $maxExpectedCourses = 100;  // Example: Max 100 courses expected

        $userPercentage = $maxExpectedUsers > 0 
            ? min(round(($totalUsers / $maxExpectedUsers) * 100), 100)
            : 0;

        $coachPercentage = $maxExpectedCoaches > 0
            ? min(round(($totalCoaches / $maxExpectedCoaches) * 100), 100)
            : 0;

        $coursePercentage = $maxExpectedCourses > 0
            ? min(round(($totalCourses / $maxExpectedCourses) * 100), 100)
            : 0;

        return view('percentage', [
            'totalUsers' => $totalUsers,
            'totalCoaches' => $totalCoaches,
            'totalCourses' => $totalCourses,
            'userPercentage' => $userPercentage,
            'coachPercentage' => $coachPercentage,
            'coursePercentage' => $coursePercentage
        ]);
    }


    /**
     * Display regular admin dashboard with users list
     */
    public function dashboard(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('lastname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
            });
        }

        $users = $query->get();

        return view('admin.dashboard', compact('users'));
    
 
    // Fetch the number of users created each month
    $users = User::select(\Illuminate\Support\Facades\DB::raw('MONTHNAME(created_at) as month'), \Illuminate\Support\Facades\DB::raw('count(*) as count'))
        ->groupBy('month')
        ->pluck('count', 'month');
        
    // Prepare the labels and data for the chart
    $labels = $users->keys();  // ['January', 'February', ...]
    $data = $users->values();  // [5, 10, 15, ...]

    // Pass the data to the view
    return view('admin.dashboard', compact('labels', 'data'));
}

}