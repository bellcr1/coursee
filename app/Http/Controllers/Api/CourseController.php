<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        \Log::info('API /api/courses hit');

        $courses = Course::all();

        \Log::info('Courses returned', ['count' => $courses->count()]);

        return response()->json($courses);
    }

    public function show($id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        return response()->json($course);
    }
}
