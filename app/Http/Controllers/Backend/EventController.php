<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->checkAuthorization(auth('admin')->user(), ['event.view']);
        
        $events = Event::orderBy('start_date', 'desc')->paginate(10);
        
        return view('backend.pages.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->checkAuthorization(auth('admin')->user(), ['event.create']);
        
        return view('backend.pages.events.create');
    }

    /**
     * Store a newly created event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->checkAuthorization(auth('admin')->user(), ['event.create']);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,cancelled',
            'is_featured' => 'boolean',
        ]);
        
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'is_featured' => $request->has('is_featured') ? 1 : 0,
        ];
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Create directory if it doesn't exist
            $destinationPath = public_path('images/events');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            $image->move($destinationPath, $imageName);
            $data['image'] = 'images/events/' . $imageName;
        }
        
        // Create event
        Event::create($data);
        
        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified event.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\View\View
     */
    public function show(Event $event)
    {
        $this->checkAuthorization(auth('admin')->user(), ['event.view']);
        
        return view('backend.pages.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified event.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\View\View
     */
    public function edit(Event $event)
    {
        $this->checkAuthorization(auth('admin')->user(), ['event.edit']);
        
        return view('backend.pages.events.edit', compact('event'));
    }

    /**
     * Update the specified event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Event $event)
    {
        $this->checkAuthorization(auth('admin')->user(), ['event.edit']);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,cancelled',
            'is_featured' => 'boolean',
        ]);
        
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'is_featured' => $request->has('is_featured') ? 1 : 0,
        ];
        
        // Update slug only if title changed
        if ($event->title !== $request->title) {
            $data['slug'] = Str::slug($request->title);
        }
        
        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete previous image if exists
            if ($event->image && File::exists(public_path($event->image))) {
                File::delete(public_path($event->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Create directory if it doesn't exist
            $destinationPath = public_path('images/events');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            $image->move($destinationPath, $imageName);
            $data['image'] = 'images/events/' . $imageName;
        }
        
        // Update event
        $event->update($data);
        
        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified event from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Event $event)
    {
        $this->checkAuthorization(auth('admin')->user(), ['event.delete']);
        
        // Delete image if exists
        if ($event->image && File::exists(public_path($event->image))) {
            File::delete(public_path($event->image));
        }
        
        $event->delete();
        
        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }
} 