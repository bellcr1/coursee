<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Resources\CourseResource;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with('categoryRelation');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('name_cotcher', 'like', "%$search%")
                  ->orWhereHas('categoryRelation', function($q2) use ($search) {
                      $q2->where('name', 'like', "%$search%");
                  });
            });
        }

        $courses = $query->get();

        return response()->json([
            'courses' => CourseResource::collection($courses)
        ]);
    }

    public function show($id)
    {
        $course = Course::with('categoryRelation')->find($id);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        return response()->json([
            'courses' => CourseResource::collection(collect([$course]))
        ]);
    }
}
