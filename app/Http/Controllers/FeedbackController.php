<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(10);
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
}