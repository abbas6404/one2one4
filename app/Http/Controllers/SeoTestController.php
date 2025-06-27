<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Seo;

class SeoTestController extends Controller
{
    /**
     * Display a test page with SEO metadata.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Set custom SEO data for this page
        Seo::setData([
            'title' => 'SEO Controller Test | One2One4',
            'description' => 'This is a test page to demonstrate the SEO controller functionality.',
            'keywords' => 'seo test, controller test, one2one4 seo',
            'image' => asset('images/social-share.jpg'),
            'type' => 'article',
        ]);
        
        return view('seo-test');
    }

    /**
     * Display a test page with dynamic SEO metadata.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Set custom SEO data for this page with dynamic content
        Seo::setData([
            'title' => "SEO Test #{$id} | One2One4",
            'description' => "This is a dynamic test page #{$id} to demonstrate the SEO middleware functionality.",
            'keywords' => "seo test {$id}, middleware test, one2one4 seo",
            'image' => asset('images/social-share.jpg'),
            'type' => 'article',
        ]);
        
        return view('seo-test', [
            'id' => $id
        ]);
    }
}
