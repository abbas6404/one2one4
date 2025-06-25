<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get page content
        $pageTitle = 'Blood Donation Events';
        $pageDescription = 'Join our upcoming blood donation events and help save lives';
        
        // Default filter for upcoming events
        $filter = $request->input('filter', 'upcoming');
        
        // Get events based on filter
        $eventsQuery = Event::query()->where('status', 'active');
        
        if ($filter === 'past') {
            $events = $eventsQuery->past()->paginate(9);
        } elseif ($filter === 'all') {
            $events = $eventsQuery->orderBy('start_date', 'desc')->paginate(9);
        } else {
            // Default: upcoming
            $events = $eventsQuery->upcoming()->paginate(9);
        }
        
        // Featured events for the carousel
        $featuredEvents = Event::active()->featured()->upcoming()->take(3)->get();
        
        return view('events', compact(
            'pageTitle',
            'pageDescription',
            'events',
            'featuredEvents',
            'filter'
        ));
    }
    
    /**
     * Display the specified event.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $event = Event::where('slug', $slug)->where('status', 'active')->firstOrFail();
        
        // Get related upcoming events
        $relatedEvents = Event::active()
            ->upcoming()
            ->where('id', '!=', $event->id)
            ->take(3)
            ->get();
            
        return view('event-details', compact('event', 'relatedEvents'));
    }
} 