<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;


class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(perPage: 10);
        return view('admin.feedback.index', compact('feedbacks'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'rating' => 'required|integer|between:1,5',
            'message' => 'required'
        ]);
        $validatedData['user_id'] = Auth::id(); // ✅ tzid id mta3 user connecté

        Feedback::create($validatedData);

        return redirect()->back()
            ->with('feedback_success', 'Thank you for your feedback!');
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->route('admin.feedback.index')
            ->with('success', 'Feedback deleted successfully');
    }


    public function edit(Feedback $feedback)
{
    if (Auth::id() !== $feedback->user_id) {
        return redirect()->back()
        ->with('refusé', 'Accès refusé!');
    }
    return view('feedback.update', compact('feedback'));
}

public function update(Request $request, Feedback $feedback)
{
    if (auth()->id() !== $feedback->user_id) {
        abort(403, 'Unauthorized');
    }

    $validatedData = $request->validate([
        'rating' => 'required|integer|between:1,5',
        'message' => 'required',
    ]);
    \Log::info('Form source: ' . $request->input('source'));

    \Log::info('All request data:', $request->all());
    $feedback->update([
        'rating' => $validatedData['rating'],
        'message' => $validatedData['message'],
    ]);


    return redirect()->route('home')->with('success', 'Feedback modifié avec succès');
}




}

