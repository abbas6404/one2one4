<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebsiteContent;

class WebsiteContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contents = WebsiteContent::all();
        return view('website-contents.index', compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('website-contents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|unique:website_contents',
            'content' => 'required',
            'type' => 'required|in:text,html,image'
        ]);

        WebsiteContent::create($request->all());
        return redirect()->route('website-contents.index')
            ->with('success', 'Content created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WebsiteContent $websiteContent)
    {
        return view('website-contents.edit', compact('websiteContent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WebsiteContent $websiteContent)
    {
        $request->validate([
            'key' => 'required|unique:website_contents,key,' . $websiteContent->id,
            'content' => 'required',
            'type' => 'required|in:text,html,image'
        ]);

        $websiteContent->update($request->all());
        return redirect()->route('website-contents.index')
            ->with('success', 'Content updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WebsiteContent $websiteContent)
    {
        $websiteContent->delete();
        return redirect()->route('website-contents.index')
            ->with('success', 'Content deleted successfully.');
    }
}
