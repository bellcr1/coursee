<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;




class CoachProfileController extends Controller
{
public function index()
{
    $users = User::findOrFail(auth()->user()->id);
    $namecat = Category::findOrFail(auth()->user()->id);

    return view('coachprofile', compact('users'), compact(  'namecat'));
}

public function edit($id)
{
    $user = User::findOrFail($id);
    $categories = Category::all();
    return view('users.edit', compact('user'), compact('categories'));
}

// Met à jour un utilisateur

}
