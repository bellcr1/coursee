<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'subject' => 'required|max:255',
            'message' => 'required'
        ]);

        Contact::create($validatedData);

        return redirect()->route('contact')
            ->with('success', 'Your message has been sent successfully!');
    }

    public function adminIndex()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }
    public function destroy(Contact $contact)
{
    $contact->delete();
    return redirect()->route('admin.contacts.index')
        ->with('success', 'Contact message deleted successfully');
}
}