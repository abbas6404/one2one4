<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BloodDonation;
use App\Models\WebsiteContent;
use Illuminate\Support\Facades\DB;

class AboutController extends Controller
{
    /**
     * Show the About Us page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Get total number of donors (users with donor role)
        $totalDonors = User::whereHas('roles', function($query) {
            $query->where('name', 'donor');
        })->count();
        
        // Get total number of successful donations
        $totalDonations = BloodDonation::where('status', 'completed')->count();
        
        // Get about page hero content from website_contents table
        $aboutTitle = WebsiteContent::where('key', 'about.hero.title')
            ->where('is_active', true)
            ->value('content') ?? 'About OneToOneFour';
            
        $aboutDescription = WebsiteContent::where('key', 'about.hero.description')
            ->where('is_active', true)
            ->value('content') ?? 'A community-driven blood donation platform connecting donors and recipients from SSF 12 and HSF 14 batch to save lives through the gift of blood.';
            
        // Get mission, vision, values content
        $missionTitle = WebsiteContent::where('key', 'about.mission.title')
            ->where('is_active', true)
            ->value('content') ?? 'Our Mission';
            
        $missionContent = WebsiteContent::where('key', 'about.mission.content')
            ->where('is_active', true)
            ->value('content') ?? 'To create a sustainable and efficient blood donation ecosystem that connects donors and recipients in real-time, ensuring that no life is lost due to lack of blood availability.';
            
        $visionTitle = WebsiteContent::where('key', 'about.vision.title')
            ->where('is_active', true)
            ->value('content') ?? 'Our Vision';
            
        $visionContent = WebsiteContent::where('key', 'about.vision.content')
            ->where('is_active', true)
            ->value('content') ?? 'To become the most trusted and accessible blood donation platform in Bangladesh, creating a network where every person in need can find a donor within minutes.';
            
        $valuesTitle = WebsiteContent::where('key', 'about.values.title')
            ->where('is_active', true)
            ->value('content') ?? 'Our Values';
            
        $valuesContent = WebsiteContent::where('key', 'about.values.content')
            ->where('is_active', true)
            ->value('content') ?? 'We believe in compassion, reliability, transparency, and community service. Every action we take is guided by our commitment to saving lives and building strong bonds within our community.';
            
        // Get journey content
        $journeyTitle = WebsiteContent::where('key', 'about.journey.title')
            ->where('is_active', true)
            ->value('content') ?? 'Our Journey';
            
        $journeyContent = WebsiteContent::where('key', 'about.journey.content')
            ->where('is_active', true)
            ->value('content') ?? 'OneToOneFour was founded in 2022 by a group of passionate individuals from SSF 12 and HSF 14 batch who recognized the critical need for an organized blood donation system within our community. What started as a small WhatsApp group for emergency blood requests has now evolved into a comprehensive platform that connects donors and recipients across Bangladesh.';
        
        // Get team section content
        $teamTitle = WebsiteContent::where('key', 'about.team.title')
            ->where('is_active', true)
            ->value('content') ?? 'Our Leadership Team';
            
        $teamDescription = WebsiteContent::where('key', 'about.team.description')
            ->where('is_active', true)
            ->value('content') ?? 'Meet the dedicated individuals who make our mission possible through their tireless efforts and commitment.';
        
        // Get CTA section content
        $ctaTitle = WebsiteContent::where('key', 'about.cta.title')
            ->where('is_active', true)
            ->value('content') ?? 'Join Our Mission';
            
        $ctaDescription = WebsiteContent::where('key', 'about.cta.description')
            ->where('is_active', true)
            ->value('content') ?? 'Every drop counts. By donating blood, you\'re not just giving blood, you\'re giving someone another chance at life.';
            
        $ctaButton = WebsiteContent::where('key', 'about.cta.button')
            ->where('is_active', true)
            ->value('content') ?? 'Become a Donor';
        
        // Get team members data from WebsiteContent
        $teamMembersData = WebsiteContent::where('key', 'like', 'about.team.member.%')
            ->where('is_active', true)
            ->orderBy('key')
            ->get();
            
        $teamMembers = [];
        foreach ($teamMembersData as $member) {
            $memberData = json_decode($member->content, true);
            if ($memberData) {
                $teamMembers[] = $memberData;
            }
        }
        
        // If no team members found, use default ones
        if (empty($teamMembers)) {
            $teamMembers = [
                [
                    'name' => 'Rafiqul Islam',
                    'position' => 'Founder & President',
                    'bio' => 'Passionate about creating a better healthcare system through technology and community engagement.',
                    'image' => 'images/team/team-1.jpg',
                    'social' => [
                        'facebook' => '#',
                        'twitter' => '#',
                        'linkedin' => '#'
                    ]
                ],
                [
                    'name' => 'Nusrat Jahan',
                    'position' => 'Operations Director',
                    'bio' => 'Coordinates blood donation drives and manages the operational aspects of our platform.',
                    'image' => 'images/team/team-2.jpg',
                    'social' => [
                        'facebook' => '#',
                        'twitter' => '#',
                        'linkedin' => '#'
                    ]
                ],
                [
                    'name' => 'Ashraful Haque',
                    'position' => 'Technical Lead',
                    'bio' => 'Oversees the development and maintenance of our digital platform and donation tracking system.',
                    'image' => 'images/team/team-3.jpg',
                    'social' => [
                        'facebook' => '#',
                        'twitter' => '#',
                        'linkedin' => '#'
                    ]
                ]
            ];
        }
        
        // Get milestones from WebsiteContent
        $milestoneData = WebsiteContent::where('key', 'like', 'about.milestone.%')
            ->where('is_active', true)
            ->get();
            
        $milestones = [];
        foreach ($milestoneData as $milestone) {
            $year = str_replace('about.milestone.', '', $milestone->key);
            $milestones[] = [
                'year' => $year,
                'description' => $milestone->content
            ];
        }
        
        // Sort milestones by year
        usort($milestones, function($a, $b) {
            return $a['year'] <=> $b['year'];
        });
        
        // If no milestones found, use default ones
        if (empty($milestones)) {
            $milestones = [
                [
                    'year' => '2022',
                    'description' => 'Initiated as a WhatsApp group for emergency blood requests among SSF 12 and HSF 14 batch members.'
                ],
                [
                    'year' => '2023',
                    'description' => 'Expanded to a Facebook group with over 500 members and facilitated 100+ successful donations.'
                ],
                [
                    'year' => '2024',
                    'description' => 'Launched the OneToOneFour platform with advanced features for matching donors and recipients in real-time.'
                ]
            ];
        }
        
        return view('about', compact(
            'totalDonors', 
            'totalDonations', 
            'aboutTitle', 
            'aboutDescription',
            'missionTitle',
            'missionContent',
            'visionTitle',
            'visionContent',
            'valuesTitle',
            'valuesContent',
            'journeyTitle',
            'journeyContent',
            'teamTitle',
            'teamDescription',
            'ctaTitle',
            'ctaDescription',
            'ctaButton',
            'teamMembers', 
            'milestones'
        ));
    }
} 