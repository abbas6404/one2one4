<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->checkAuthorization(auth('admin')->user(), ['event.view']);
        
        $query = Event::query();
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by featured status
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured);
        }
        
        // Filter by time (upcoming, ongoing, past)
        if ($request->filled('time_filter')) {
            $now = Carbon::now();
            
            if ($request->time_filter === 'upcoming') {
                $query->where('start_date', '>', $now);
            } elseif ($request->time_filter === 'ongoing') {
                $query->where('start_date', '<=', $now)
                      ->where('end_date', '>=', $now);
            } elseif ($request->time_filter === 'past') {
                $query->where('end_date', '<', $now);
            }
        }
        
        // Default ordering
        $query->orderBy('start_date', 'desc');
        
        $events = $query->with(['division', 'district', 'upazila'])->paginate(10);
        
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
        
        // Get all divisions, districts, and upazilas for location dropdowns
        $divisions = \App\Models\Division::orderBy('name')->get();
        $districts = \App\Models\District::orderBy('name')->get();
        $upazilas = \App\Models\Upazila::orderBy('name')->get();
        
        return view('backend.pages.events.create', compact('divisions', 'districts', 'upazilas'));
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
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,cancelled',
            'is_featured' => 'boolean',
            'event_fee' => 'nullable|string|max:50',
            'division_id' => 'nullable|exists:divisions,id',
            'district_id' => 'nullable|exists:districts,id',
            'upazila_id' => 'nullable|exists:upazilas,id',
        ]);
        
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'is_featured' => $request->has('is_featured') ? 1 : 0,
            'event_fee' => $request->event_fee,
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'upazila_id' => $request->upazila_id,
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
        
        // Load location relationships
        $event->load(['division', 'district', 'upazila']);
        
        // Get internal program statistics
        $internalProgramStats = [
            'total' => $event->internalPrograms()->count(),
            'pending' => $event->internalPrograms()->where('status', 'pending')->count(),
            'approved' => $event->internalPrograms()->where('status', 'approved')->count(),
            'rejected' => $event->internalPrograms()->where('status', 'rejected')->count(),
            'total_amount' => $event->internalPrograms()->where('status', 'approved')->sum('payment_amount'),
            'all_amount' => $event->internalPrograms()->sum('payment_amount'),
        ];
        
        return view('backend.pages.events.show', compact('event', 'internalProgramStats'));
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
        
        // Get all divisions, districts, and upazilas for location dropdowns
        $divisions = \App\Models\Division::orderBy('name')->get();
        $districts = \App\Models\District::orderBy('name')->get();
        $upazilas = \App\Models\Upazila::orderBy('name')->get();
        
        return view('backend.pages.events.edit', compact('event', 'divisions', 'districts', 'upazilas'));
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
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,cancelled',
            'is_featured' => 'boolean',
            'event_fee' => 'nullable|string|max:50',
            'division_id' => 'nullable|exists:divisions,id',
            'district_id' => 'nullable|exists:districts,id',
            'upazila_id' => 'nullable|exists:upazilas,id',
        ]);
        
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'is_featured' => $request->has('is_featured') ? 1 : 0,
            'event_fee' => $request->event_fee,
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'upazila_id' => $request->upazila_id,
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