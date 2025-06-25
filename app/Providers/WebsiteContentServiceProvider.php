<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\WebsiteContent;

class WebsiteContentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('website-content', function ($app) {
            return new class {
                public function get($key, $default = null)
                {
                    $content = WebsiteContent::where('key', $key)
                        ->where('is_active', true)
                        ->first();
                    
                    return $content ? $content->content : $default;
                }
            };
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
