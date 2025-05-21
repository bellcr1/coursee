<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CoachController extends Controller
{
    public function edit($id)
    {
        if (Auth::id() != $id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
    
        $user = User::findOrFail($id);
        
        // Prepare common expertises for the form
        $commonExpertises = [
            'Course Design',
            'Interactive Learning',
            'Student Engagement',
            'Digital Assessment',
            'Curriculum Development',
            'E-Learning'
        ];
        
        return view('coach.edit', compact('user', 'commonExpertises'));
    }

    public function update(Request $request, $id)
    {
        /*if (Auth::id()!= $id &&!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }*/

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'expertises' => 'sometimes|array',
            'expertises.*' => 'string|max:255',
            'custom_expertise' => 'nullable|string|max:500'
        ]);

        $user = User::findOrFail($id);
        $data = $request->except(['image', 'expertises', 'custom_expertise']);

        // Handle expertise data
        $expertises = $request->input('expertises', []);
        
        if ($request->filled('custom_expertise')) {
            $customExpertises = array_map('trim', explode(',', $request->custom_expertise));
            $expertises = array_merge($expertises, $customExpertises);
        }
        
        // Clean and store expertise data
        $data['expertise'] = !empty($expertises) ? implode(',', array_unique(array_filter($expertises))) : null;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/coaches'), $imageName);
            $data['image'] = 'images/coaches/' . $imageName;
        }

        $user->update($data);

        return redirect()->route('coach.profile', $user->id)
        ->with('success', 'Profile updated successfully');
}
public function show($id)
{
    $user = User::findOrFail($id);
    return view('coachprofile', compact('user'));
}
}