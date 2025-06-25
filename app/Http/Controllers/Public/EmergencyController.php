<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\WebsiteContent;
use Illuminate\Http\Request;

class EmergencyController extends Controller
{
    /**
     * Display the emergency contact page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get page title and description
        $pageTitle = WebsiteContent::where('key', 'emergency.title')
            ->where('is_active', true)
            ->value('content') ?? 'Emergency Blood Donor Contacts';
            
        $pageDescription = WebsiteContent::where('key', 'emergency.description')
            ->where('is_active', true)
            ->value('content') ?? 'Need blood urgently? Contact these emergency hotlines or nearby donors immediately.';
        
        // Get emergency hotlines
        $hotlinesData = WebsiteContent::where('key', 'like', 'emergency.hotline.%')
            ->where('is_active', true)
            ->orderBy('key')
            ->get();
            
        $hotlines = [];
        foreach ($hotlinesData as $hotline) {
            $data = json_decode($hotline->content, true);
            if ($data) {
                $hotlines[] = $data;
            }
        }
        
        // Get "What to do" instructions
        $whatToDoTitle = WebsiteContent::where('key', 'emergency.what_to_do.title')
            ->where('is_active', true)
            ->value('content') ?? 'What to do in a blood emergency:';
            
        $whatToDoContent = WebsiteContent::where('key', 'emergency.what_to_do.content')
            ->where('is_active', true)
            ->value('content');
            
        $whatToDo = json_decode($whatToDoContent, true) ?? [
            'Stay calm and assess the situation.',
            'Call the emergency hotlines listed here.',
            'Provide details about the blood type needed and the hospital location.',
            'Share the emergency requirement on social media platforms.',
            'Contact family and friends who may be able to donate.'
        ];
        
        // Get "Required information" instructions
        $requiredInfoTitle = WebsiteContent::where('key', 'emergency.required_info.title')
            ->where('is_active', true)
            ->value('content') ?? 'Required Information:';
            
        $requiredInfoContent = WebsiteContent::where('key', 'emergency.required_info.content')
            ->where('is_active', true)
            ->value('content');
            
        $requiredInfo = json_decode($requiredInfoContent, true) ?? [
            'Patient\'s name and age',
            'Blood type required',
            'Hospital name and location',
            'Contact person and phone number',
            'How many units are required',
            'Reason for blood requirement (optional)'
        ];
        
        return view('emergency', compact(
            'pageTitle',
            'pageDescription',
            'hotlines',
            'whatToDoTitle',
            'whatToDo',
            'requiredInfoTitle',
            'requiredInfo'
        ));
    }
} 