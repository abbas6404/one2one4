<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\WebsiteContent;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    /**
     * Store a new team member
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $this->checkAuthorization(auth('admin')->user(), ['website.content.create']);
            
            $request->validate([
                'team_name' => 'required|string|max:100',
                'team_position' => 'required|string|max:100',
                'team_description' => 'nullable|string|max:500',
                'team_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'team_facebook' => 'nullable|url|max:255',
                'team_twitter' => 'nullable|url|max:255',
                'team_linkedin' => 'nullable|url|max:255',
            ]);

            // Create a unique key for the team member
            $existingMembers = WebsiteContent::where('key', 'like', 'about.team.member.%')->count();
            $memberId = $existingMembers + 1;
            $key = 'about.team.member.' . $memberId;
            
            // Check if this key already exists (just in case)
            while (WebsiteContent::where('key', $key)->exists()) {
                $memberId++;
                $key = 'about.team.member.' . $memberId;
            }
            
            // Handle image upload
            $imagePath = 'images/team/placeholder.jpg';
            if ($request->hasFile('team_image')) {
                $image = $request->file('team_image');
                $filename = time() . '_' . str_replace(' ', '_', $request->team_name) . '.' . $image->getClientOriginalExtension();
                
                // Create directory if it doesn't exist
                $destinationPath = public_path('images/team');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                
                // Move the file
                $image->move($destinationPath, $filename);
                $imagePath = 'images/team/' . $filename;
            }
            
            // Create data structure for team member
            $memberData = [
                'name' => $request->team_name,
                'position' => $request->team_position,
                'bio' => $request->team_description ?? '',
                'image' => $imagePath,
                'social' => [
                    'facebook' => $request->team_facebook ?? '#',
                    'twitter' => $request->team_twitter ?? '#',
                    'linkedin' => $request->team_linkedin ?? '#'
                ]
            ];
            
            // Create new team member
            WebsiteContent::create([
                'key' => $key,
                'content' => json_encode($memberData),
                'is_active' => true
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Team member added successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update an existing team member
     */
    public function update(Request $request): JsonResponse
    {
        try {
            $this->checkAuthorization(auth('admin')->user(), ['website.content.edit']);
            
            $request->validate([
                'team_id' => 'required|exists:website_contents,id',
                'team_name' => 'required|string|max:100',
                'team_position' => 'required|string|max:100',
                'team_description' => 'nullable|string|max:500',
                'team_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'team_facebook' => 'nullable|url|max:255',
                'team_twitter' => 'nullable|url|max:255',
                'team_linkedin' => 'nullable|url|max:255',
            ]);
            
            $teamMember = WebsiteContent::findOrFail($request->team_id);
            
            // Get existing data or create default data structure
            $memberData = json_decode($teamMember->content, true);
            if (!$memberData || !is_array($memberData)) {
                $memberData = [
                    'name' => '',
                    'position' => '',
                    'bio' => '',
                    'image' => 'images/team/placeholder.jpg',
                    'social' => [
                        'facebook' => '#',
                        'twitter' => '#',
                        'linkedin' => '#'
                    ]
                ];
            }
            
            // Handle image upload
            if ($request->hasFile('team_image')) {
                // Delete old image if it exists and is not the placeholder
                if (isset($memberData['image']) && 
                    $memberData['image'] !== 'images/team/placeholder.jpg' && 
                    file_exists(public_path($memberData['image']))) {
                    unlink(public_path($memberData['image']));
                }
                
                $image = $request->file('team_image');
                $filename = time() . '_' . str_replace(' ', '_', $request->team_name) . '.' . $image->getClientOriginalExtension();
                
                // Create directory if it doesn't exist
                $destinationPath = public_path('images/team');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                
                // Move the file
                $image->move($destinationPath, $filename);
                $memberData['image'] = 'images/team/' . $filename;
            } elseif ($request->has('current_image_path') && $request->current_image_path) {
                // Keep existing image
                $memberData['image'] = $request->current_image_path;
            }
            
            // Update with new data
            $memberData['name'] = $request->team_name;
            $memberData['position'] = $request->team_position;
            $memberData['bio'] = $request->team_description ?? '';
            $memberData['social'] = [
                'facebook' => $request->team_facebook ?? '#',
                'twitter' => $request->team_twitter ?? '#',
                'linkedin' => $request->team_linkedin ?? '#'
            ];
            
            // Update team member
            $teamMember->update([
                'content' => json_encode($memberData)
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Team member updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Delete a team member
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            $this->checkAuthorization(auth('admin')->user(), ['website.content.delete']);
            
            $request->validate([
                'team_id' => 'required|exists:website_contents,id',
            ]);
            
            $teamMember = WebsiteContent::findOrFail($request->team_id);
            
            // Delete the image file if it's not the placeholder
            $memberData = json_decode($teamMember->content, true);
            if ($memberData && isset($memberData['image']) && 
                $memberData['image'] !== 'images/team/placeholder.jpg' && 
                file_exists(public_path($memberData['image']))) {
                unlink(public_path($memberData['image']));
            }
            
            // Delete the team member record
            $teamMember->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Team member deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
} 