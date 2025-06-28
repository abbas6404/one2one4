<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InternalProgram;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;
use App\Models\Event;
use Illuminate\Support\Str;


class InternalProgramController extends Controller
{
    /**
     * Show the registration form for internal programs.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $divisions = Division::all();
        
        // Get all active events
        $activeEvents = Event::where('status', 'active')
                          ->orderBy('start_date', 'asc')
                          ->get();
        
        // Find the first featured event to use as default
        $defaultEvent = $activeEvents->where('is_featured', true)->first();
        
        // If no featured events, use the first active event as default
        if (!$defaultEvent && $activeEvents->isNotEmpty()) {
            $defaultEvent = $activeEvents->first();
        }
        
        return view('internal-program-registration', compact('divisions', 'activeEvents', 'defaultEvent'));
    }

    /**
     * Handle the registration request for internal programs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'blood_group' => 'required|string|max:10',
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'upazila_id' => 'required|exists:upazilas,id',
            'tshirt_size' => 'required|string|max:10',
            'payment_method' => 'required|string|max:50',
            'payment_amount' => 'nullable|numeric',
            'trx_id' => 'nullable|string|max:100',
            'screenshot' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'event_id' => 'nullable|exists:events,id',
        ]);
        
        // Normalize payment method name
        if ($validated['payment_method'] === 'Bank_Transfer') {
            $validated['payment_method'] = 'Bank Transfer';
        }
        
        // Set default status to pending
        $validated['status'] = 'pending';
        
        // Handle screenshot upload
        if ($request->hasFile('screenshot')) {
            $image = $request->file('screenshot');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = 'images/internal_programs/';
            $image->move(public_path($path), $filename);
            $validated['screenshot'] = $path . $filename;
        }
        
        // Create the internal program registration
        $program = InternalProgram::create($validated);
        
        // Get event name if selected
        $eventName = '';
        if (!empty($program->event_id)) {
            $event = Event::find($program->event_id);
            if ($event) {
                $eventName = $event->title;
            }
        }
        
        // Redirect back with success message
        return redirect()->route('internal-program.registration')
            ->with('success', 'Thank you for your registration! ' . 
                  ($eventName ? "You have successfully registered for the event: $eventName. " : '') . 
                  'We will contact you soon with further details.');
    }

    /**
     * Check registration status by phone number.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkStatus(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'phone_number' => 'required|string|max:20',
        ]);
        
        // Find the registration by phone number
        $registration = InternalProgram::with('event')
            ->where('phone', $validated['phone_number'])
            ->latest()
            ->first();
        
        if ($registration) {
            return response()->json([
                'success' => true,
                'registration' => $registration
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No registration found with the provided phone number.'
            ]);
        }
    }
} 