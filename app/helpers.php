<?php

use App\Models\WebsiteContent;
use Illuminate\Support\Str;
use App\Facades\Seo;

if (!function_exists('get_website_content')) {
    /**
     * Get website content by key
     * 
     * @param string $key The key to retrieve content for
     * @param string|null $default Default value if content not found
     * @return string|null
     */
    function get_website_content(string $key, ?string $default = null): ?string
    {
        $content = WebsiteContent::where('key', $key)
            ->where('is_active', true)
            ->first();
            
        return $content ? $content->content : $default;
    }
}

/**
 * Generate a URL friendly slug from a string
 *
 * @param string $string
 * @return string
 */
function slug($string)
{
    return Str::slug($string);
}

/**
 * Format a date string
 *
 * @param string $date
 * @param string $format
 * @return string
 */
function format_date($date, $format = 'd M, Y')
{
    return date($format, strtotime($date));
}

/**
 * Get a setting value
 *
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function setting($key, $default = null)
{
    return app('website-content')->get($key, $default);
}

/**
 * Generate SEO meta tags for a page
 *
 * @param array $data
 * @return array
 */
function seo_meta($data = [])
{
    // Set SEO data if provided
    if (!empty($data)) {
        Seo::setData($data);
    }

    return Seo::getData();
}

/**
 * Generate schema.org structured data for blood donation organization
 *
 * @return string JSON-LD structured data
 */
function blood_donation_schema()
{
    return Seo::getOrganizationSchema();
}

/**
 * Generate schema.org structured data for blood donation event
 *
 * @param array $event Event details
 * @return string JSON-LD structured data
 */
function blood_donation_event_schema($event)
{
    return Seo::getEventSchema([
        'name' => $event['title'] ?? 'Blood Donation Camp',
        'description' => $event['description'] ?? 'Join our blood donation camp and help save lives.',
        'startDate' => $event['start_date'] ?? date('Y-m-d'),
        'endDate' => $event['end_date'] ?? date('Y-m-d'),
        'image' => $event['image'] ?? asset('images/events/blood-donation-camp.jpg'),
        'location' => [
            'name' => $event['location'] ?? 'One2One4 Blood Donation Center',
            'streetAddress' => $event['address'] ?? '',
            'addressLocality' => $event['city'] ?? 'Dhaka',
            'addressCountry' => 'BD',
        ]
    ]);
}

/**
 * Generate schema.org structured data for blood donation FAQ
 *
 * @param array $faqs List of FAQs
 * @return string JSON-LD structured data
 */
function blood_donation_faq_schema($faqs)
{
    $faqList = [];
    
    foreach ($faqs as $faq) {
        $faqList[] = [
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faq['answer']
            ]
        ];
    }
    
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $faqList
    ];

    return json_encode($schema);
}

/**
 * Generate Open Graph meta tags for social sharing
 *
 * @param array $data
 * @return string HTML meta tags
 */
function open_graph_tags($data = [])
{
    // Set SEO data if provided
    if (!empty($data)) {
        Seo::setData($data);
    }
    
    $tags = [
        '<meta property="og:title" content="' . e(Seo::getTitle()) . '">',
        '<meta property="og:description" content="' . e(Seo::getDescription()) . '">',
        '<meta property="og:image" content="' . e(Seo::getImage()) . '">',
        '<meta property="og:url" content="' . e(Seo::getCanonical()) . '">',
        '<meta property="og:type" content="' . e(Seo::getType()) . '">',
        '<meta property="og:site_name" content="One2One4 Blood Donation">',
    ];
    
    return implode("\n    ", $tags);
}

/**
 * Generate Twitter Card meta tags for social sharing
 *
 * @param array $data
 * @return string HTML meta tags
 */
function twitter_card_tags($data = [])
{
    // Set SEO data if provided
    if (!empty($data)) {
        Seo::setData($data);
    }
    
    $tags = [
        '<meta name="twitter:card" content="summary_large_image">',
        '<meta name="twitter:title" content="' . e(Seo::getTitle()) . '">',
        '<meta name="twitter:description" content="' . e(Seo::getDescription()) . '">',
        '<meta name="twitter:image" content="' . e(Seo::getImage()) . '">',
        '<meta name="twitter:url" content="' . e(Seo::getCanonical()) . '">',
    ];
    
    return implode("\n    ", $tags);
} 