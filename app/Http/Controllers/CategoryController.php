<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $categories = $query->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories',
            'description' => 'nullable',
            'icon' => 'required|string',
            'icon_color' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    $data = $request->all();
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/categories'), $imageName);
        $data['image'] = 'images/categories/' . $imageName;
    }
    // Set default icon if not provided
    $data['icon'] = $request->icon ?? 'fas fa-folder';
    $data['icon_color'] = $request->icon_color ?? '#3498db';
    
    Category::create($data);
    return redirect()->route('categories.index')->with('success', 'Category created successfully');
}

public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|unique:categories,name,' . $category->id,
        'description' => 'nullable',
        'icon' => 'required|string',
        'icon_color' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);
    $data = $request->all();
    if ($request->hasFile('image')) {
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/categories'), $imageName);
        $data['image'] = 'images/categories/' . $imageName;
    }
    $category->update($data);
    return redirect()->route('categories.index')->with('success', 'Category updated successfully');
}

public function destroy(Category $category)
{
    if ($category->image && file_exists(public_path($category->image))) {
        unlink(public_path($category->image));
    }
    
    $category->delete();
    return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
}
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }
}