<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Division;
use App\Models\Sponsor;
use App\Models\WebsiteContent;
use App\Models\Testimonial;

class HomeController extends Controller
{
    /**
     * Show the application home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get website content
        $websiteContent = WebsiteContent::pluck('content', 'key');
        
        // Get hero slides data from WebsiteContent
        $hero_slides = [
            [
                'title' => $websiteContent['site.hero.slide1.title'] ?? 'Blood Donation',
                'subtitle' => $websiteContent['site.hero.slide1.subtitle'] ?? 'Donating blood is quick, easy and safe',
                'image' => isset($websiteContent['site.hero.slide1.image']) ? 'storage/' . $websiteContent['site.hero.slide1.image'] : 'images/blood-donation-slide1.png',
            ],
            [
                'title' => $websiteContent['site.hero.slide2.title'] ?? 'Save Lives',
                'subtitle' => $websiteContent['site.hero.slide2.subtitle'] ?? 'Your donation can save up to three lives',
                'image' => isset($websiteContent['site.hero.slide2.image']) ? 'storage/' . $websiteContent['site.hero.slide2.image'] : 'images/blood-donation-slide2.png',
            ],
            [
                'title' => $websiteContent['site.hero.slide3.title'] ?? 'Be a Hero',
                'subtitle' => $websiteContent['site.hero.slide3.subtitle'] ?? 'Give the gift of life by donating blood today',
                'image' => isset($websiteContent['site.hero.slide3.image']) ? 'storage/' . $websiteContent['site.hero.slide3.image'] : 'images/blood-donation-slide3.png',
            ],
        ];
        
        // Get total donor count
        $total_donor = User::where('is_donor', true)
                          ->where('status', 'active')
                          ->count();
        
        // Get available donor count (those who are eligible to donate)
        $available_donor = User::where('is_donor', true)
                             ->where('status', 'active')
                             ->where(function($q) {
                                 $q->whereNull('last_donation_date')
                                   ->orWhere('last_donation_date', '<=', now()->subMonths(4));
                             })
                             ->count();
        
        // Get total donations count
        $total_donation = DB::table('blood_donations')->count();
        
        // Get blood group distribution
        $blood_groups = DB::table('users')
                         ->select('blood_group as blood_category', DB::raw('count(*) as total'))
                         ->where('is_donor', true)
                         ->where('status', 'active')
                         ->groupBy('blood_group')
                         ->get();
        
        // Get divisions for location dropdown
        $divisions = Division::orderBy('name', 'asc')->get();
        
        // Get dynamic limit from website content for testimonials
        $testimonials_limit = (int)($websiteContent['site.testimonials.limit'] ?? 6);
        
        // Get testimonials from database with caching
        $testimonials = Testimonial::getActiveHomepageTestimonials($testimonials_limit);
        
        // If no testimonials in database, use the sample ones
        if ($testimonials->isEmpty()) {
            $testimonials = [
                (object)[
                    'id' => 1,
                    'name' => 'Jane Smith',
                    'content' => 'The blood donation saved my life after a serious accident. I\'m forever grateful to the donors who took the time to give blood. Now I\'m a regular donor myself to pay it forward.',
                    'avatar' => 'images/testimonials/avatar.png',
                    'blood_group' => 'B+',
                    'type' => 'Blood Recipient',
                    'location' => 'Dhaka'
                ],
                (object)[
                    'id' => 2,
                    'name' => 'John Doe',
                    'content' => 'I donate blood regularly because I know it saves lives. The process is quick and easy, and the staff is always friendly and professional. I encourage everyone who can to donate.',
                    'avatar' => 'images/testimonials/avatar.png',
                    'blood_group' => 'O+',
                    'type' => 'Blood Donor',
                    'location' => 'Chittagong'
                ],
                (object)[
                    'id' => 3,
                    'name' => 'Rahul Khan',
                    'content' => 'I was in desperate need of a rare blood type for my mother\'s surgery. Thanks to this community, we found a donor within hours!',
                    'avatar' => 'images/testimonials/avatar.png',
                    'blood_group' => 'AB-',
                    'type' => 'Blood Recipient',
                    'location' => 'Sylhet'
                ]
            ];
        }
        
        // Get dynamic limit from website content for sponsors
        $sponsors_limit = (int)($websiteContent['site.sponsors.limit'] ?? 8);
        
        // Get sponsors from database with caching
        $sponsors = Sponsor::getActiveHomepageSponsors($sponsors_limit);
        
        // Get contact section data
        $contact = [
            'title' => $websiteContent['home.contact.title'] ?? 'CONTACT US',
            'subtitle' => $websiteContent['home.contact.description'] ?? 'Have questions about blood donation or need assistance? We\'re here to help!',
            'info_title' => $websiteContent['home.contact.info.title'] ?? 'Blood Donation Platform',
            'info_tagline' => $websiteContent['home.contact.info.tagline'] ?? 'Saving lives through voluntary blood donation',
            'form_title' => $websiteContent['home.contact.form.title'] ?? 'Send us a Message',
            'button_text' => $websiteContent['home.contact.button'] ?? 'Send Message'
        ];
        
        return view('index', compact(
            'total_donor', 
            'available_donor', 
            'total_donation', 
            'blood_groups', 
            'testimonials',
            'hero_slides',
            'sponsors',
            'divisions',
            'websiteContent',
            'contact'
        ));
    }
} 