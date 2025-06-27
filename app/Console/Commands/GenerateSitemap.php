<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Event;
use App\Models\Gallery;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.xml file for One2One4 Blood Donation website';

    /**
     * The site URL
     * 
     * @var string
     */
    protected $siteUrl;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->siteUrl = config('app.url');
        $this->info('Generating sitemap for ' . $this->siteUrl);

        $sitemap = $this->generateSitemapXml();
        
        File::put(public_path('sitemap.xml'), $sitemap);
        
        $this->info('Sitemap generated successfully at public/sitemap.xml');
    }

    /**
     * Generate sitemap XML content
     * 
     * @return string
     */
    protected function generateSitemapXml()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        
        // Add static pages
        $staticPages = [
            '' => ['priority' => '1.0', 'changefreq' => 'daily'],
            'about' => ['priority' => '0.8', 'changefreq' => 'monthly'],
            'contact' => ['priority' => '0.8', 'changefreq' => 'monthly'],
            'donors' => ['priority' => '0.9', 'changefreq' => 'daily'],
            'emergency' => ['priority' => '0.9', 'changefreq' => 'daily'],
            'gallery' => ['priority' => '0.7', 'changefreq' => 'weekly'],
        ];
        
        foreach ($staticPages as $page => $meta) {
            $xml .= $this->addUrl(
                $this->siteUrl . '/' . $page,
                Carbon::now()->format('Y-m-d'),
                $meta['changefreq'],
                $meta['priority']
            );
        }
        
        // Add dynamic pages if models exist
        if (class_exists('App\Models\User')) {
            try {
                // Check if columns exist
                $userQuery = User::query();
                
                if (Schema::hasColumn('users', 'is_donor')) {
                    $userQuery->where('is_donor', true);
                }
                
                if (Schema::hasColumn('users', 'is_public')) {
                    $userQuery->where('is_public', true);
                }
                
                // Add donor profiles
                $donors = $userQuery->limit(100)->get();
                
                foreach ($donors as $donor) {
                    $xml .= $this->addUrl(
                        $this->siteUrl . '/donors/' . $donor->id,
                        $donor->updated_at->format('Y-m-d'),
                        'weekly',
                        '0.6'
                    );
                }
            } catch (\Exception $e) {
                $this->warn('Error adding donor URLs: ' . $e->getMessage());
            }
        }
        
        if (class_exists('App\Models\Event')) {
            try {
                $eventQuery = Event::query();
                
                if (Schema::hasColumn('events', 'status')) {
                    $eventQuery->where('status', 'active');
                }
                
                if (Schema::hasColumn('events', 'end_date')) {
                    $eventQuery->where('end_date', '>=', Carbon::now());
                }
                
                // Add events
                $events = $eventQuery->limit(50)->get();
                
                foreach ($events as $event) {
                    $xml .= $this->addUrl(
                        $this->siteUrl . '/events/' . $event->id,
                        $event->updated_at->format('Y-m-d'),
                        'weekly',
                        '0.7'
                    );
                }
            } catch (\Exception $e) {
                $this->warn('Error adding event URLs: ' . $e->getMessage());
            }
        }
        
        if (class_exists('App\Models\Gallery')) {
            try {
                $galleryQuery = Gallery::query();
                
                if (Schema::hasColumn('galleries', 'status')) {
                    $galleryQuery->where('status', 'active');
                }
                
                // Add gallery items
                $galleryItems = $galleryQuery->limit(50)->get();
                
                foreach ($galleryItems as $item) {
                    $xml .= $this->addUrl(
                        $this->siteUrl . '/gallery/' . $item->id,
                        $item->updated_at->format('Y-m-d'),
                        'monthly',
                        '0.6'
                    );
                }
            } catch (\Exception $e) {
                $this->warn('Error adding gallery URLs: ' . $e->getMessage());
            }
        }
        
        $xml .= '</urlset>';
        
        return $xml;
    }
    
    /**
     * Add URL to sitemap
     * 
     * @param string $loc
     * @param string $lastmod
     * @param string $changefreq
     * @param string $priority
     * @return string
     */
    protected function addUrl($loc, $lastmod, $changefreq, $priority)
    {
        return "  <url>\n" .
               "    <loc>" . $loc . "</loc>\n" .
               "    <lastmod>" . $lastmod . "</lastmod>\n" .
               "    <changefreq>" . $changefreq . "</changefreq>\n" .
               "    <priority>" . $priority . "</priority>\n" .
               "  </url>\n";
    }
}
