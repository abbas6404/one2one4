<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\WebsiteContent;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class MilestoneController extends Controller
{
    /**
     * Store a new milestone
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $this->checkAuthorization(auth('admin')->user(), ['website.content.create']);
            
            $request->validate([
                'milestone_year' => 'required|integer|min:1900|max:2100',
                'milestone_content' => 'required|string|max:500',
            ]);

            $key = 'about.milestone.' . $request->milestone_year;
            
            // Check if milestone for this year already exists
            $existingMilestone = WebsiteContent::where('key', $key)->first();
            if ($existingMilestone) {
                return response()->json([
                    'success' => false,
                    'message' => 'Milestone for year ' . $request->milestone_year . ' already exists.'
                ]);
            }
            
            // Create new milestone
            WebsiteContent::create([
                'key' => $key,
                'content' => $request->milestone_content,
                'is_active' => true
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Milestone added successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update an existing milestone
     */
    public function update(Request $request): JsonResponse
    {
        try {
            $this->checkAuthorization(auth('admin')->user(), ['website.content.edit']);
            
            $request->validate([
                'milestone_id' => 'required|exists:website_contents,id',
                'milestone_year' => 'required|integer|min:1900|max:2100',
                'milestone_content' => 'required|string|max:500',
            ]);
            
            $milestone = WebsiteContent::findOrFail($request->milestone_id);
            $newKey = 'about.milestone.' . $request->milestone_year;
            
            // Check if the year is being changed and if that year already exists (except current milestone)
            if ($milestone->key != $newKey) {
                $existingMilestone = WebsiteContent::where('key', $newKey)->first();
                if ($existingMilestone) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Milestone for year ' . $request->milestone_year . ' already exists.'
                    ]);
                }
            }
            
            // Update milestone
            $milestone->update([
                'key' => $newKey,
                'content' => $request->milestone_content
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Milestone updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Delete a milestone
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            $this->checkAuthorization(auth('admin')->user(), ['website.content.delete']);
            
            $request->validate([
                'milestone_id' => 'required|exists:website_contents,id',
            ]);
            
            $milestone = WebsiteContent::findOrFail($request->milestone_id);
            $milestone->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Milestone deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
} 