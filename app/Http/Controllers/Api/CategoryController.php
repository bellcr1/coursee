<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

        public function index()
        {
            \Log::info('API /api/courses hit');
    
            $Category = Category::all();
    
            \Log::info('Courses returned', ['count' => $Category->count()]);
    
            return response()->json($Category);
        }
    
        public function show($id)
        {
            $Category = Category::find($id);
    
            if (!$Category) {
                return response()->json(['message' => 'Course not found'], 404);
            }
    
            return response()->json($Category);
        }
    }
    
