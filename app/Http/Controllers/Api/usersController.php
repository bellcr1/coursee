<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class usersController extends Controller
{
    public function getUsersByRole(Request $request)
    {
        $role = $request->input('role');
        $search = $request->input('search');
    
        $users = User::where('role', $role)
            ->when(!empty($search), function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                      ->orWhere('lastname', 'like', "%$search%");
                });
            })
            ->get();
    
        return response()->json($users);
    }
}