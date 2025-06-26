<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('REDIRECT_HTTPS')) {
            URL::forceScheme('https');
        }
        
        // Use Bootstrap 4 for pagination rendering
        Paginator::useBootstrap();
        
        // Configure mail to not use queues
        Mail::alwaysFrom(env('MAIL_FROM_ADDRESS', 'info@one2one4.org'), env('MAIL_FROM_NAME', 'One2One4 Blood Donation'));
    }
}
