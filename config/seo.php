<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default SEO Settings
    |--------------------------------------------------------------------------
    |
    | These are the default SEO settings for your application. These values
    | will be used when no specific SEO data is set for a page.
    |
    */
    'default' => [
        'title' => 'One2One4 - Blood Donation Platform of Bangladesh',
        'description' => 'One2One4 is Bangladesh\'s largest blood donation platform connecting donors and recipients across all upazilas. Find blood donors, request blood, and save lives.',
        'keywords' => 'blood donation, blood donors, Bangladesh, blood bank, blood donation near me, find blood donors, request blood, blood group, blood donation app',
        'image' => 'images/social-share.jpg',
        'author' => 'One2One4 Team',
        'twitter_handle' => '@one2one4bd',
        'twitter_card_type' => 'summary_large_image',
        'facebook_app_id' => '',
        'locale' => 'en_US',
        'site_name' => 'One2One4',
    ],

    /*
    |--------------------------------------------------------------------------
    | Route-specific SEO Settings
    |--------------------------------------------------------------------------
    |
    | These settings will override the default settings for specific routes.
    | Use the route name as the key.
    |
    */
    'routes' => [
        'home' => [
            'title' => 'One2One4 - Blood Donation Platform of Bangladesh',
            'description' => 'One2One4 connects blood donors with recipients across Bangladesh. Find blood donors in your area, request blood, and join our life-saving community.',
        ],
        'about' => [
            'title' => 'About Us | One2One4 Blood Donation',
            'description' => 'Learn about One2One4\'s mission to create Bangladesh\'s largest blood donor network. Our history, team, and commitment to saving lives through blood donation.',
        ],
        'contact' => [
            'title' => 'Contact Us | One2One4 Blood Donation',
            'description' => 'Get in touch with One2One4 blood donation platform. Contact our team for support, partnerships, or to learn more about our blood donation services.',
        ],
        'donor.list' => [
            'title' => 'Blood Donors Directory | One2One4',
            'description' => 'Find blood donors across Bangladesh. Search by location, blood group, and availability. Connect directly with verified blood donors through One2One4.',
        ],
        'blood.request' => [
            'title' => 'Request Blood | One2One4 Blood Donation',
            'description' => 'Need blood urgently? Submit a blood request on One2One4 and connect with donors in your area. Emergency blood request service available 24/7.',
        ],
        'register' => [
            'title' => 'Register as Blood Donor | One2One4',
            'description' => 'Join One2One4\'s blood donor community. Register as a blood donor and help save lives across Bangladesh. Simple registration process.',
            'robots' => 'noindex, follow',
        ],
        'login' => [
            'title' => 'Login | One2One4 Blood Donation',
            'description' => 'Login to your One2One4 blood donor account. Access your donation history, update profile, and respond to blood requests.',
            'robots' => 'noindex, follow',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Organization Schema
    |--------------------------------------------------------------------------
    |
    | Settings for the Organization schema used in structured data
    |
    */
    'organization' => [
        'name' => 'One2One4',
        'url' => 'https://one2one4.com',
        'logo' => 'images/logo.png',
        'description' => 'Bangladesh\'s largest blood donation platform connecting donors across all upazilas.',
        'foundingDate' => '2020',
        'address' => [
            'streetAddress' => '',
            'addressLocality' => 'Dhaka',
            'addressRegion' => 'Dhaka',
            'postalCode' => '1000',
            'addressCountry' => 'BD',
        ],
        'contactPoint' => [
            'telephone' => '+880-XXX-XXXXXX',
            'contactType' => 'customer service',
        ],
        'sameAs' => [
            'https://facebook.com/one2one4',
            'https://twitter.com/one2one4',
            'https://instagram.com/one2one4',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Geo Settings
    |--------------------------------------------------------------------------
    |
    | Geographic settings for your application
    |
    */
    'geo' => [
        'region' => 'BD',
        'placename' => 'Bangladesh',
        'position' => '23.8103;90.4125',
    ],
]; 