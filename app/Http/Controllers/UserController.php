<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    // Affiche la liste des utilisateurs
    public function index()
    {
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }

    // Affiche le formulaire de création
    // Affiche le formulaire de modification
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('users.edit', compact('user', 'categories'));
    }
    

    // Met à jour un utilisateur
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
            'description' => 'nullable|string',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'category' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = User::findOrFail($id);
        $data = [
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'role' => $request->role,
            'description' => $request->description,
            'linkedin_url' => $request->linkedin_url,
            'twitter_url' => $request->twitter_url,
            'category' => $request->category,
            'image' => $user->image // Keep existing image by default
        ];

      
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/users'), $imageName);
            $data['image'] = 'images/users/' . $imageName;
        }

        $user->update($data);
        if ($user->role=='Admin') {
            return redirect()->route('users.index');
        }
        return redirect()->route('admin.dashboard', $user->id)->with('success', 'User updated successfully');
    }

    // Supprime un utilisateur
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully');
    }


}
