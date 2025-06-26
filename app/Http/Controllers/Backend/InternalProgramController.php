<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\InternalProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InternalProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->checkAuthorization(auth('admin')->user(), ['internal.program.view']);
        
        $query = InternalProgram::query();
        
        // Apply filters if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('blood_group')) {
            $query->where('blood_group', $request->blood_group);
        }
        
        // Date filtering
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('phone', 'like', $searchTerm)
                  ->orWhere('email', 'like', $searchTerm);
            });
        }
        
        // Sort by date
        $query->latest();
        
        // Paginate the results
        $internalPrograms = $query->paginate(10)->withQueryString();
            
        return view('backend.pages.internal-programs.index', compact('internalPrograms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkAuthorization(auth('admin')->user(), ['internal.program.create']);
        return view('backend.pages.internal-programs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkAuthorization(auth('admin')->user(), ['internal.program.create']);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'blood_group' => 'required|string|max:10',
            'present_address' => 'required|string',
            'tshirt_size' => 'required|string|max:10',
            'payment_method' => 'required|string|max:50',
            'trx_id' => 'nullable|string|max:100',
            'screenshot' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'sometimes|in:pending,approved,rejected',
        ]);
        
        // Handle screenshot upload
        if ($request->hasFile('screenshot')) {
            $image = $request->file('screenshot');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = 'images/internal_programs/';
            $image->move(public_path($path), $filename);
            $validated['screenshot'] = $path . $filename;
        }
        
        InternalProgram::create($validated);
        
        return redirect()->route('admin.internal-programs.index')
            ->with('success', 'Internal program registration created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(InternalProgram $internalProgram)
    {
        $this->checkAuthorization(auth('admin')->user(), ['internal.program.view']);
        return view('backend.pages.internal-programs.show', compact('internalProgram'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InternalProgram $internalProgram)
    {
        $this->checkAuthorization(auth('admin')->user(), ['internal.program.edit']);
        return view('backend.pages.internal-programs.edit', compact('internalProgram'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InternalProgram $internalProgram)
    {
        $this->checkAuthorization(auth('admin')->user(), ['internal.program.edit']);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'blood_group' => 'required|string|max:10',
            'present_address' => 'required|string',
            'tshirt_size' => 'required|string|max:10',
            'payment_method' => 'required|string|max:50',
            'trx_id' => 'nullable|string|max:100',
            'screenshot' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:pending,approved,rejected',
        ]);
        
        // Handle screenshot upload
        if ($request->hasFile('screenshot')) {
            // Delete old screenshot if exists
            if ($internalProgram->screenshot && file_exists(public_path($internalProgram->screenshot))) {
                unlink(public_path($internalProgram->screenshot));
            }
            
            $image = $request->file('screenshot');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = 'images/internal_programs/';
            $image->move(public_path($path), $filename);
            $validated['screenshot'] = $path . $filename;
        }
        
        $internalProgram->update($validated);
        
        return redirect()->route('admin.internal-programs.index')
            ->with('success', 'Internal program updated successfully');
    }

    /**
     * Update the status of an internal program.
     */
    public function updateStatus(Request $request, InternalProgram $internalProgram)
    {
        $this->checkAuthorization(auth('admin')->user(), ['internal.program.edit']);
        
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $internalProgram->update(['status' => $request->status]);

        $statusMessages = [
            'pending' => 'Internal program marked as pending',
            'approved' => 'Internal program approved successfully',
            'rejected' => 'Internal program rejected successfully'
        ];

        return back()->with('success', $statusMessages[$request->status] ?? 'Status updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InternalProgram $internalProgram)
    {
        $this->checkAuthorization(auth('admin')->user(), ['internal.program.delete']);
        
        $internalProgram->delete();
        
        return redirect()->route('admin.internal-programs.index')
            ->with('success', 'Internal program deleted successfully');
    }
    
    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $this->checkAuthorization(auth('admin')->user(), ['internal.program.delete']);
        
        $internalProgram = InternalProgram::withTrashed()->findOrFail($id);
        $internalProgram->restore();
        
        return redirect()->route('admin.internal-programs.index')
            ->with('success', 'Internal program restored successfully');
    }
    
    /**
     * Display a listing of trashed resources.
     */
    public function trashed()
    {
        $this->checkAuthorization(auth('admin')->user(), ['internal.program.delete']);
        
        $trashedPrograms = InternalProgram::onlyTrashed()->latest()->paginate(10);
        
        return view('backend.pages.internal-programs.trashed', compact('trashedPrograms'));
    }
    
    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $this->checkAuthorization(auth('admin')->user(), ['internal.program.delete']);
        
        $internalProgram = InternalProgram::withTrashed()->findOrFail($id);
        
        // Delete screenshot if exists
        if ($internalProgram->screenshot && file_exists(public_path($internalProgram->screenshot))) {
            unlink(public_path($internalProgram->screenshot));
        }
        
        $internalProgram->forceDelete();
        
        return redirect()->route('admin.internal-programs.trashed')
            ->with('success', 'Internal program permanently deleted');
    }
}
