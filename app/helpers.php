<?php

use App\Models\WebsiteContent;

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