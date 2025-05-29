<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with(['user' => function($query) {
            $query->where('role', 'coach');
        }])->latest()->get();
        
        return view('admin.contracts.index', compact('contracts'));
    }

    public function create()
    {
        $coaches = User::where('role', 'coach')->get();
        return view('admin.contracts.create', compact('coaches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id,role,coach',
            'title' => 'required|string|max:255',
            'terms' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);
    
        // Remove the hardcoded status
        $contract = Contract::create([
            'user_id' => $validated['user_id'],
            'title' => $validated['title'],
            'terms' => $validated['terms'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            
        ]);
    
        if ($request->hasFile('document')) {
            $contract->update([
                'document_path' => $request->file('document')->store('contracts')
            ]);
        }
    
        return redirect()->route('admin.contracts.index')->with('success', 'Contract created!');
    }

    public function destroy(Contract $contract)
    {
        if ($contract->document_path) {
            Storage::delete($contract->document_path);
        }
        $contract->delete();
        return back()->with('success', 'Contract deleted!');
    }
}