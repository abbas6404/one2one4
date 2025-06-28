<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BloodDonation;
use App\Models\BloodRequest;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentMonth = Carbon::now()->startOfMonth();
        $currentDate = Carbon::now();
        
        // Get calendar data
        $calendarData = $this->generateCalendarData($currentMonth);
        
        // Get events for the current month
        $events = $this->getMonthEvents($currentMonth);
        
        // Get upcoming events
        $upcomingEvents = $this->getUpcomingEvents();
        
        // Get quick stats
        $stats = $this->getQuickStats($user);
        
        return view('frontend.calendar.index', compact(
            'calendarData', 
            'events', 
            'upcomingEvents', 
            'stats', 
            'currentDate'
        ));
    }
    
    public function changeMonth(Request $request)
    {
        $month = Carbon::parse($request->month);
        $calendarData = $this->generateCalendarData($month);
        $events = $this->getMonthEvents($month);
        
        return response()->json([
            'calendarData' => $calendarData,
            'events' => $events,
            'monthDisplay' => $month->format('F Y')
        ]);
    }
    
    private function generateCalendarData($month)
    {
        $startOfMonth = Carbon::parse($month)->startOfMonth();
        $endOfMonth = Carbon::parse($month)->endOfMonth();
        
        $startDay = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        $endDay = $endOfMonth->copy()->endOfWeek(Carbon::SATURDAY);
        
        $days = [];
        $currentDay = $startDay->copy();
        
        while ($currentDay <= $endDay) {
            $days[] = [
                'date' => $currentDay->format('Y-m-d'),
                'day' => $currentDay->day,
                'month' => $currentDay->month,
                'isCurrentMonth' => $currentDay->month === $month->month,
                'isToday' => $currentDay->isToday(),
            ];
            
            $currentDay->addDay();
        }
        
        return [
            'days' => $days,
            'monthStart' => $startOfMonth->format('Y-m-d'),
            'monthEnd' => $endOfMonth->format('Y-m-d'),
            'month' => $month->format('F Y')
        ];
    }
    
    private function getMonthEvents($month)
    {
        $user = Auth::user();
        $startOfMonth = Carbon::parse($month)->startOfMonth();
        $endOfMonth = Carbon::parse($month)->endOfMonth();
        
        // Get blood donations for the month
        $donations = BloodDonation::where('donor_id', $user->id)
            ->whereBetween('donation_date', [$startOfMonth, $endOfMonth])
            ->get()
            ->map(function ($donation) {
                return [
                    'id' => $donation->id,
                    'title' => 'Blood Donation',
                    'date' => Carbon::parse($donation->donation_date)->format('Y-m-d'),
                    'time' => Carbon::parse($donation->donation_date)->format('h:i A'),
                    'type' => 'donation',
                    'status' => $donation->status,
                    'url' => route('user.donation.show', $donation->id),
                    'color' => 'bg-danger'
                ];
            });
            
        // Get blood requests for the month
        $requests = BloodRequest::where('user_id', $user->id)
            ->whereBetween('needed_date', [$startOfMonth, $endOfMonth])
            ->get()
            ->map(function ($request) {
                return [
                    'id' => $request->id,
                    'title' => 'Blood Request',
                    'date' => Carbon::parse($request->needed_date)->format('Y-m-d'),
                    'time' => Carbon::parse($request->needed_date)->format('h:i A'),
                    'type' => 'request',
                    'status' => $request->status,
                    'url' => route('user.blood-requests.show', $request->id),
                    'color' => 'bg-primary'
                ];
            });
            
        // Get public events for the month
        $publicEvents = Event::where('start_date', '>=', $startOfMonth)
            ->where('end_date', '<=', $endOfMonth)
            ->where('status', 'active')
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'date' => Carbon::parse($event->start_date)->format('Y-m-d'),
                    'time' => Carbon::parse($event->start_date)->format('h:i A'),
                    'type' => 'event',
                    'url' => route('events.show', $event->id),
                    'color' => 'bg-info'
                ];
            });
            
        // Combine all events
        return $donations->concat($requests)->concat($publicEvents)
            ->groupBy('date')
            ->toArray();
    }
    
    private function getUpcomingEvents()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $nextMonth = Carbon::today()->addMonth();
        
        // Get upcoming donations
        $donations = BloodDonation::where('donor_id', $user->id)
            ->where('donation_date', '>=', $today)
            ->where('donation_date', '<=', $nextMonth)
            ->where('status', '!=', 'rejected')
            ->orderBy('donation_date')
            ->limit(3)
            ->get()
            ->map(function ($donation) {
                return [
                    'id' => $donation->id,
                    'title' => 'Blood Donation',
                    'date' => Carbon::parse($donation->donation_date)->format('Y-m-d'),
                    'time' => Carbon::parse($donation->donation_date)->format('h:i A'),
                    'dateForHumans' => Carbon::parse($donation->donation_date)->diffForHumans(),
                    'type' => 'donation',
                    'url' => route('user.donation.show', $donation->id),
                    'color' => 'bg-danger'
                ];
            });
            
        // Get upcoming blood requests
        $requests = BloodRequest::where('user_id', $user->id)
            ->where('needed_date', '>=', $today)
            ->where('needed_date', '<=', $nextMonth)
            ->where('status', '!=', 'rejected')
            ->orderBy('needed_date')
            ->limit(3)
            ->get()
            ->map(function ($request) {
                return [
                    'id' => $request->id,
                    'title' => 'Blood Request',
                    'date' => Carbon::parse($request->needed_date)->format('Y-m-d'),
                    'time' => Carbon::parse($request->needed_date)->format('h:i A'),
                    'dateForHumans' => Carbon::parse($request->needed_date)->diffForHumans(),
                    'type' => 'request',
                    'url' => route('user.blood-requests.show', $request->id),
                    'color' => 'bg-primary'
                ];
            });
            
        // Get upcoming events
        $events = Event::where('start_date', '>=', $today)
            ->where('start_date', '<=', $nextMonth)
            ->where('status', 'active')
            ->orderBy('start_date')
            ->limit(3)
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'date' => Carbon::parse($event->start_date)->format('Y-m-d'),
                    'time' => Carbon::parse($event->start_date)->format('h:i A'),
                    'dateForHumans' => Carbon::parse($event->start_date)->diffForHumans(),
                    'type' => 'event',
                    'url' => route('events.show', $event->id),
                    'color' => 'bg-info'
                ];
            });
            
        // Combine and sort by date
        return $donations->concat($requests)->concat($events)
            ->sortBy('date')
            ->take(5)
            ->values();
    }
    
    private function getQuickStats($user)
    {
        // Get total appointments for this month
        $totalAppointments = BloodDonation::where('donor_id', $user->id)
            ->whereMonth('donation_date', Carbon::now()->month)
            ->count();
            
        // Get days until next eligible donation
        $daysUntilEligible = 0;
        $formattedTimeRemaining = 'Now';
        
        if ($user->last_donation_date) {
            $nextEligibleDate = Carbon::parse($user->last_donation_date)->addMonths(4);
            $daysUntilEligible = max(0, now()->diffInDays($nextEligibleDate, false));
            
            if ($daysUntilEligible > 0) {
                $months = floor($daysUntilEligible / 30);
                $days = $daysUntilEligible % 30;
                
                if ($months > 0) {
                    $formattedTimeRemaining = $months . 'm ' . $days . 'd';
                } else {
                    $formattedTimeRemaining = $days . ' days';
                }
            } else {
                $formattedTimeRemaining = 'Now';
            }
        }
        
        return [
            'totalAppointments' => $totalAppointments,
            'daysUntilEligible' => $daysUntilEligible,
            'formattedTimeRemaining' => $formattedTimeRemaining
        ];
    }
} 