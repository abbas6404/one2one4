<?php

namespace App\Services;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Arr;

class SeoService
{
    /**
     * SEO data for the current page
     *
     * @var array
     */
    protected $data = [];

    /**
     * Create a new SeoService instance.
     */
    public function __construct()
    {
        $this->data = [
            'title' => config('seo.default.title', 'One2One4 Blood Donation'),
            'description' => config('seo.default.description', ''),
            'keywords' => config('seo.default.keywords', ''),
            'canonical' => $this->getCanonicalUrl(),
            'image' => asset(config('seo.default.image', 'images/social-share.jpg')),
            'type' => 'website',
            'robots' => 'index, follow',
            'author' => config('seo.default.author', ''),
            'twitter_handle' => config('seo.default.twitter_handle', ''),
            'twitter_card_type' => config('seo.default.twitter_card_type', 'summary_large_image'),
            'facebook_app_id' => config('seo.default.facebook_app_id', ''),
            'locale' => config('seo.default.locale', 'en_US'),
            'site_name' => config('seo.default.site_name', 'One2One4'),
        ];
    }

    /**
     * Set SEO data
     *
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    /**
     * Get all SEO data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get page title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->data['title'];
    }

    /**
     * Get page description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->data['description'];
    }

    /**
     * Get page keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->data['keywords'];
    }

    /**
     * Get canonical URL
     *
     * @return string
     */
    public function getCanonical()
    {
        return $this->data['canonical'] ?? $this->getCanonicalUrl();
    }

    /**
     * Get page image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->data['image'];
    }

    /**
     * Get page type
     *
     * @return string
     */
    public function getType()
    {
        return $this->data['type'];
    }

    /**
     * Get robots directive
     *
     * @return string
     */
    public function getRobots()
    {
        return $this->data['robots'];
    }

    /**
     * Generate canonical URL for current page
     *
     * @return string
     */
    protected function getCanonicalUrl()
    {
        // Start with the current URL
        $url = Request::url();
        
        // Force HTTPS
        $url = str_replace('http://', 'https://', $url);
        
        // Remove trailing slash
        $url = rtrim($url, '/');
        
        // Add query parameters if they exist and are important
        $query = Request::query();
        
        // Filter out unnecessary query parameters
        $excludedParams = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'fbclid', 'gclid'];
        $query = array_diff_key($query, array_flip($excludedParams));
        
        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }
        
        return $url;
    }

    /**
     * Generate structured data for the organization
     *
     * @return string
     */
    public function getOrganizationSchema()
    {
        $organization = config('seo.organization');
        
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $organization['name'],
            'url' => $organization['url'],
            'logo' => asset($organization['logo']),
            'description' => $organization['description'],
        ];
        
        if (!empty($organization['foundingDate'])) {
            $schema['foundingDate'] = $organization['foundingDate'];
        }
        
        if (!empty($organization['address'])) {
            $schema['address'] = [
                '@type' => 'PostalAddress',
                'streetAddress' => $organization['address']['streetAddress'],
                'addressLocality' => $organization['address']['addressLocality'],
                'addressRegion' => $organization['address']['addressRegion'],
                'postalCode' => $organization['address']['postalCode'],
                'addressCountry' => $organization['address']['addressCountry'],
            ];
        }
        
        if (!empty($organization['contactPoint'])) {
            $schema['contactPoint'] = [
                '@type' => 'ContactPoint',
                'telephone' => $organization['contactPoint']['telephone'],
                'contactType' => $organization['contactPoint']['contactType'],
            ];
        }
        
        if (!empty($organization['sameAs'])) {
            $schema['sameAs'] = $organization['sameAs'];
        }
        
        return json_encode($schema);
    }

    /**
     * Generate breadcrumb structured data
     *
     * @param array $breadcrumbs
     * @return string
     */
    public function getBreadcrumbSchema(array $breadcrumbs)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [],
        ];
        
        foreach ($breadcrumbs as $position => $breadcrumb) {
            $schema['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $position + 1,
                'name' => $breadcrumb['name'],
                'item' => $breadcrumb['url'],
            ];
        }
        
        return json_encode($schema);
    }

    /**
     * Generate article structured data
     *
     * @param array $article
     * @return string
     */
    public function getArticleSchema(array $article)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $article['headline'] ?? $this->getTitle(),
            'description' => $article['description'] ?? $this->getDescription(),
            'image' => $article['image'] ?? $this->getImage(),
            'datePublished' => $article['datePublished'] ?? now()->toIso8601String(),
            'dateModified' => $article['dateModified'] ?? now()->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $article['author'] ?? $this->data['author'],
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('seo.organization.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset(config('seo.organization.logo')),
                ],
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $this->getCanonical(),
            ],
        ];
        
        return json_encode($schema);
    }

    /**
     * Generate event structured data
     *
     * @param array $event
     * @return string
     */
    public function getEventSchema(array $event)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Event',
            'name' => $event['name'] ?? $this->getTitle(),
            'description' => $event['description'] ?? $this->getDescription(),
            'image' => $event['image'] ?? $this->getImage(),
            'startDate' => $event['startDate'],
            'endDate' => $event['endDate'] ?? $event['startDate'],
            'location' => [
                '@type' => 'Place',
                'name' => $event['location']['name'],
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $event['location']['streetAddress'] ?? '',
                    'addressLocality' => $event['location']['addressLocality'] ?? '',
                    'addressRegion' => $event['location']['addressRegion'] ?? '',
                    'postalCode' => $event['location']['postalCode'] ?? '',
                    'addressCountry' => $event['location']['addressCountry'] ?? 'BD',
                ],
            ],
            'organizer' => [
                '@type' => 'Organization',
                'name' => config('seo.organization.name'),
                'url' => config('seo.organization.url'),
            ],
        ];
        
        return json_encode($schema);
    }

    /**
     * Generate product structured data
     *
     * @param array $product
     * @return string
     */
    public function getProductSchema(array $product)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product['name'] ?? $this->getTitle(),
            'description' => $product['description'] ?? $this->getDescription(),
            'image' => $product['image'] ?? $this->getImage(),
        ];
        
        if (!empty($product['offers'])) {
            $schema['offers'] = [
                '@type' => 'Offer',
                'price' => $product['offers']['price'],
                'priceCurrency' => $product['offers']['priceCurrency'] ?? 'BDT',
                'availability' => $product['offers']['availability'] ?? 'https://schema.org/InStock',
            ];
        }
        
        return json_encode($schema);
    }

    /**
     * Generate structured data for the current page
     *
     * @return string
     */
    public function getStructuredData()
    {
        // By default, return organization schema
        return $this->getOrganizationSchema();
    }

    /**
     * Generate meta tags for the current page
     *
     * @return string
     */
    public function generateMetaTags()
    {
        $tags = [];
        
        // Primary meta tags
        $tags[] = '<meta name="title" content="' . e($this->getTitle()) . '">';
        $tags[] = '<meta name="description" content="' . e($this->getDescription()) . '">';
        
        if ($this->getKeywords()) {
            $tags[] = '<meta name="keywords" content="' . e($this->getKeywords()) . '">';
        }
        
        // Canonical URL
        $tags[] = '<link rel="canonical" href="' . e($this->getCanonical()) . '">';
        
        // Robots directive
        $tags[] = '<meta name="robots" content="' . e($this->getRobots()) . '">';
        
        // Open Graph tags
        $tags[] = '<meta property="og:title" content="' . e($this->getTitle()) . '">';
        $tags[] = '<meta property="og:description" content="' . e($this->getDescription()) . '">';
        $tags[] = '<meta property="og:url" content="' . e($this->getCanonical()) . '">';
        $tags[] = '<meta property="og:image" content="' . e($this->getImage()) . '">';
        $tags[] = '<meta property="og:type" content="' . e($this->getType()) . '">';
        $tags[] = '<meta property="og:site_name" content="' . e($this->data['site_name']) . '">';
        $tags[] = '<meta property="og:locale" content="' . e($this->data['locale']) . '">';
        
        // Twitter Card tags
        $tags[] = '<meta name="twitter:card" content="' . e($this->data['twitter_card_type']) . '">';
        
        if ($this->data['twitter_handle']) {
            $tags[] = '<meta name="twitter:site" content="' . e($this->data['twitter_handle']) . '">';
            $tags[] = '<meta name="twitter:creator" content="' . e($this->data['twitter_handle']) . '">';
        }
        
        $tags[] = '<meta name="twitter:title" content="' . e($this->getTitle()) . '">';
        $tags[] = '<meta name="twitter:description" content="' . e($this->getDescription()) . '">';
        $tags[] = '<meta name="twitter:image" content="' . e($this->getImage()) . '">';
        
        // Facebook App ID
        if ($this->data['facebook_app_id']) {
            $tags[] = '<meta property="fb:app_id" content="' . e($this->data['facebook_app_id']) . '">';
        }
        
        // Author
        if ($this->data['author']) {
            $tags[] = '<meta name="author" content="' . e($this->data['author']) . '">';
        }
        
        // Geo tags
        $geo = config('seo.geo');
        if ($geo) {
            $tags[] = '<meta name="geo.region" content="' . e($geo['region']) . '">';
            $tags[] = '<meta name="geo.placename" content="' . e($geo['placename']) . '">';
            
            if (!empty($geo['position'])) {
                $tags[] = '<meta name="geo.position" content="' . e($geo['position']) . '">';
                $tags[] = '<meta name="ICBM" content="' . e($geo['position']) . '">';
            }
        }
        
        return implode("\n    ", $tags);
    }
}
