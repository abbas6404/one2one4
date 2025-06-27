<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class SeoMiddleware
{
    /**
     * SEO-related headers to add to responses
     * 
     * @var array
     */
    protected $seoHeaders = [
        'X-Robots-Tag' => 'index, follow',
        'X-Content-Type-Options' => 'nosniff',
        'Referrer-Policy' => 'strict-origin-when-cross-origin',
        'Permissions-Policy' => 'camera=(), microphone=(), geolocation=(self)',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only apply to HTML responses
        if (!$this->isHtmlResponse($response)) {
            return $response;
        }

        // Add SEO headers
        foreach ($this->seoHeaders as $header => $value) {
            $response->headers->set($header, $value);
        }

        // Add canonical URL header for GET requests
        if ($request->isMethod('GET')) {
            $canonical = $this->getCanonicalUrl($request);
            $response->headers->set('Link', "<{$canonical}>; rel=\"canonical\"");
        }

        return $response;
    }

    /**
     * Check if the response is HTML
     *
     * @param Response $response
     * @return bool
     */
    protected function isHtmlResponse(Response $response): bool
    {
        $contentType = $response->headers->get('Content-Type');
        return $contentType && Str::contains($contentType, 'text/html');
    }

    /**
     * Get canonical URL for the request
     *
     * @param Request $request
     * @return string
     */
    protected function getCanonicalUrl(Request $request): string
    {
        // Start with the current URL
        $url = $request->url();
        
        // Force HTTPS
        $url = str_replace('http://', 'https://', $url);
        
        // Remove trailing slash
        $url = rtrim($url, '/');
        
        // Add query parameters if they exist and are important
        $query = $request->query();
        
        // Filter out unnecessary query parameters
        $excludedParams = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'fbclid', 'gclid'];
        $query = array_diff_key($query, array_flip($excludedParams));
        
        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }
        
        return $url;
    }
}
