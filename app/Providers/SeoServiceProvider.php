<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Services\SeoService;

class SeoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register SEO config
        $this->mergeConfigFrom(
            __DIR__.'/../../config/seo.php', 'seo'
        );

        // Register SeoService
        $this->app->singleton('seo', function ($app) {
            return new SeoService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Force HTTPS in production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Share SEO data with all views
        View::composer('*', function ($view) {
            $route = Route::currentRouteName();
            $request = request();

            $view->with('seo', $this->getSeoData($route, $request));
        });

        // Publish config file
        $this->publishes([
            __DIR__.'/../../config/seo.php' => config_path('seo.php'),
        ], 'seo-config');
    }

    /**
     * Get SEO data based on current route
     *
     * @param string|null $route
     * @param Request $request
     * @return array
     */
    protected function getSeoData(?string $route, Request $request): array
    {
        $defaultData = [
            'title' => config('seo.default.title', 'One2One4 Blood Donation'),
            'description' => config('seo.default.description', 'One2One4 - Bangladesh\'s largest blood donation platform connecting donors across all upazilas.'),
            'keywords' => config('seo.default.keywords', 'blood donation, blood donors, Bangladesh, blood bank'),
            'image' => asset(config('seo.default.image', 'images/social-share.jpg')),
            'type' => 'website',
            'robots' => 'index, follow',
        ];

        // Get route-specific SEO data from config
        $routeData = [];
        if ($route && config("seo.routes.{$route}")) {
            $routeData = config("seo.routes.{$route}");
        }

        // Get dynamic data based on request parameters
        $dynamicData = $this->getDynamicSeoData($request);

        // Merge data with priority: dynamic > route > default
        return array_merge($defaultData, $routeData, $dynamicData);
    }

    /**
     * Get dynamic SEO data based on request parameters
     *
     * @param Request $request
     * @return array
     */
    protected function getDynamicSeoData(Request $request): array
    {
        $data = [];

        // Example: If viewing a donor profile
        if ($request->segment(1) === 'donors' && $request->segment(2)) {
            $donorId = $request->segment(2);
            
            // Try to get donor data if model exists
            if (class_exists('App\\Models\\User')) {
                $donor = \App\Models\User::find($donorId);
                
                if ($donor) {
                    $data['title'] = $donor->name . ' - Blood Donor Profile | One2One4';
                    $data['description'] = "View {$donor->name}'s blood donor profile. Blood Type: {$donor->blood_group}. Contact and schedule a blood donation.";
                    
                    if ($donor->profile_image) {
                        $data['image'] = asset($donor->profile_image);
                    }
                }
            }
        }

        // Example: If viewing an event
        if ($request->segment(1) === 'events' && $request->segment(2)) {
            $eventId = $request->segment(2);
            
            // Try to get event data if model exists
            if (class_exists('App\\Models\\Event')) {
                $event = \App\Models\Event::find($eventId);
                
                if ($event) {
                    $data['title'] = $event->title . ' | One2One4 Blood Donation Event';
                    $data['description'] = $event->description ?? "Join our blood donation event: {$event->title}. Date: {$event->start_date}.";
                    $data['type'] = 'event';
                    
                    if ($event->image) {
                        $data['image'] = asset($event->image);
                    }
                }
            }
        }

        return $data;
    }
}
