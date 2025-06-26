<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Traits\AuthorizationChecker;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReply;

class ContactController extends Controller
{
    use AuthorizationChecker;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->checkAuthorization(auth('admin')->user(), ['contact.view']);
        
        $query = Contact::query();
        
        // Filter by status if provided
        if ($request->has('status') && in_array($request->status, ['read', 'unread'])) {
            $query->where('status', $request->status);
        }
        
        // Sort by created date, newest first
        $query->orderBy('created_at', 'desc');
        
        $contacts = $query->paginate(10)->withQueryString();
        
        return view('backend.pages.contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->checkAuthorization(auth('admin')->user(), ['contact.view']);
        
        $contact = Contact::findOrFail($id);
        
        // Mark as read if not already
        if ($contact->status !== 'read') {
            $contact->status = 'read';
            $contact->save();
        }
        
        return view('backend.pages.contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->checkAuthorization(auth('admin')->user(), ['contact.update']);
        
        $contact = Contact::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:read,unread',
        ]);
        
        $contact->status = $request->status;
        $contact->save();
        
        return redirect()->back()->with('success', 'Contact status updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->checkAuthorization(auth('admin')->user(), ['contact.delete']);
        
        $contact = Contact::findOrFail($id);
        $contact->delete();
        
        return redirect()->route('admin.contacts.index')->with('success', 'Contact deleted successfully');
    }

    /**
     * Reply to a contact message via email.
     */
    public function reply(Request $request, string $id)
    {
        $this->checkAuthorization(auth('admin')->user(), ['contact.update']);
        
        $contact = Contact::findOrFail($id);
        
        $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        
        try {
            // Send email
            Mail::to($request->to)
                ->send(new ContactReply($contact, $request->subject, $request->message));
            
            // Mark as read
            if ($contact->status !== 'read') {
                $contact->status = 'read';
                $contact->save();
            }
            
            return redirect()->back()->with('success', 'Reply sent successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send reply: ' . $e->getMessage())->withInput();
        }
    }
}
