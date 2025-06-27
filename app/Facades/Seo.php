<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array getData()
 * @method static string getTitle()
 * @method static string getDescription()
 * @method static string getKeywords()
 * @method static string getCanonical()
 * @method static string getImage()
 * @method static string getType()
 * @method static string getRobots()
 * @method static string getStructuredData()
 * @method static string getOrganizationSchema()
 * @method static string getBreadcrumbSchema(array $breadcrumbs)
 * @method static string getArticleSchema(array $article)
 * @method static string getProductSchema(array $product)
 * @method static string getEventSchema(array $event)
 * 
 * @see \App\Services\SeoService
 */
class Seo extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'seo';
    }
}
