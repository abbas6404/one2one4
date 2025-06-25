@extends('backend.layouts.master')

@section('title', 'Web Template')

@section('styles')
<!-- Add CSRF token meta tag for Ajax requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .nav-tabs .nav-link {
        color: #333;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        margin-right: 5px;
    }
    .nav-tabs .nav-link.active {
        color: #fff;
        background-color: #7057f7;
        border-color: #7057f7;
    }
    .content-section {
        padding: 20px;
        border: 1px solid #dee2e6;
        border-top: none;
    }
    .form-section {
        margin-bottom: 15px;
    }
    .form-section label {
        font-weight: 500;
    }
    .save-btn {
        margin-top: 15px;
    }
    .custom-file {
        position: relative;
        display: inline-block;
        width: 100%;
        height: calc(1.5em + 0.75rem + 2px);
        margin-bottom: 0;
    }
    .custom-file-input {
        position: relative;
        z-index: 2;
        width: 100%;
        height: calc(1.5em + 0.75rem + 2px);
        margin: 0;
        opacity: 0;
    }
    .custom-file-label {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1;
        height: calc(1.5em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .custom-file-label::after {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        display: block;
        height: calc(1.5em + 0.75rem);
        padding: 0.375rem 0.75rem;
        line-height: 1.5;
        color: #495057;
        content: "Browse";
        background-color: #e9ecef;
        border-left: inherit;
        border-radius: 0 0.25rem 0.25rem 0;
    }
    .slider-preview {
        display: inline-block;
        margin-right: 10px;
        vertical-align: middle;
    }
    
    /* Milestone styles */
    #milestoneTable {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    #milestoneTable th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    
    #milestoneTable td, #milestoneTable th {
        padding: 12px 15px;
        vertical-align: middle;
        border: 1px solid #e9ecef;
    }
    
    #milestoneTable tbody tr {
        transition: all 0.2s ease;
    }
    
    #milestoneTable tbody tr:hover {
        background-color: rgba(112, 87, 247, 0.05);
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    .edit-milestone, .delete-milestone {
        margin: 0 2px;
    }
    
    .milestone-card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: all 0.3s ease;
    }
    
    .milestone-card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }
    
    .milestone-card .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        font-weight: 600;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Web Template</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>Web Template</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Manage Web Template</h4>
                    <p class="text-muted">Customize your website content by section</p>

                    <ul class="nav nav-tabs" id="websiteContentTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                                <i class="fa fa-home"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="false">
                                <i class="fa fa-cog"></i> General
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="about-tab" data-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="false">
                                <i class="fa fa-info-circle"></i> About Us
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="donors-tab" data-toggle="tab" href="#donors" role="tab" aria-controls="donors" aria-selected="false">
                                <i class="fa fa-users"></i> Donor List
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="gallery-tab" data-toggle="tab" href="#gallery" role="tab" aria-controls="gallery" aria-selected="false">
                                <i class="fa fa-image"></i> Gallery
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="emergency-tab" data-toggle="tab" href="#emergency" role="tab" aria-controls="emergency" aria-selected="false">
                                <i class="fa fa-ambulance"></i> Emergency
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="milestones-tab" data-toggle="tab" href="#milestones" role="tab" aria-controls="milestones" aria-selected="false">
                                <i class="fa fa-history"></i> Milestones
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="team-tab" data-toggle="tab" href="#team" role="tab" aria-controls="team" aria-selected="false">
                                <i class="fa fa-user-circle"></i> Team
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                                <i class="fa fa-envelope"></i> Contact
                            </a>
                        </li>

                    </ul>

                    <div class="tab-content mt-3" id="websiteContentTabContent">
                        <!-- Home Tab Content -->
                        <div class="tab-pane fade show active content-section" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <h5 class="mb-4">Home Page Settings</h5>
                            <form id="home-form" method="POST" action="{{ route('admin.web-template.update') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="section" value="home">
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="site_title">Site Title</label>
                                        <input type="text" class="form-control" id="site_title" name="content[site.title]" value="{{ get_website_content('site.title') }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="site_subtitle">Site Subtitle</label>
                                        <input type="text" class="form-control" id="site_subtitle" name="content[site.subtitle]" value="{{ get_website_content('site.subtitle') }}">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="site_notification">Notification Banner</label>
                                    <input type="text" class="form-control" id="site_notification" name="content[site.notification]" value="{{ get_website_content('site.notification') }}">
                                </div>

                                <h6 class="mt-4">Slider Content</h6>
                                <div class="alert alert-info mb-3">
                                    <i class="fa fa-info-circle mr-2"></i> Slider images will be saved directly to <strong>images/slides</strong> directory. Recommended size: 1920x800 pixels.
                                </div>
                                <div class="row">
                                    <div class="col-md-4 form-section">
                                        <label>Slide 1</label>
                                        <div class="form-group">
                                            <label for="slide1_title">Title</label>
                                            <input type="text" class="form-control" id="slide1_title" name="content[site.hero.slide1.title]" value="{{ get_website_content('site.hero.slide1.title') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="slide1_subtitle">Subtitle</label>
                                            <input type="text" class="form-control" id="slide1_subtitle" name="content[site.hero.slide1.subtitle]" value="{{ get_website_content('site.hero.slide1.subtitle') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="slide1_image">Image</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="slide1_image" name="images[site.hero.slide1.image]">
                                                <label class="custom-file-label" for="slide1_image">Choose image</label>
                                            </div>
                                            <div class="mt-2">
                                                @if(get_website_content('site.hero.slide1.image'))
                                                    <div class="slider-preview">
                                                        <img src="{{ asset(get_website_content('site.hero.slide1.image')) }}" class="img-thumbnail" style="max-height: 100px">
                                                    </div>
                                                @endif
                                                <small class="form-text text-muted">Images will be saved in: images/slides</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-section">
                                        <label>Slide 2</label>
                                        <div class="form-group">
                                            <label for="slide2_title">Title</label>
                                            <input type="text" class="form-control" id="slide2_title" name="content[site.hero.slide2.title]" value="{{ get_website_content('site.hero.slide2.title') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="slide2_subtitle">Subtitle</label>
                                            <input type="text" class="form-control" id="slide2_subtitle" name="content[site.hero.slide2.subtitle]" value="{{ get_website_content('site.hero.slide2.subtitle') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="slide2_image">Image</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="slide2_image" name="images[site.hero.slide2.image]">
                                                <label class="custom-file-label" for="slide2_image">Choose image</label>
                                            </div>
                                            <div class="mt-2">
                                                @if(get_website_content('site.hero.slide2.image'))
                                                    <div class="slider-preview">
                                                        <img src="{{ asset(get_website_content('site.hero.slide2.image')) }}" class="img-thumbnail" style="max-height: 100px">
                                                    </div>
                                                @endif
                                                <small class="form-text text-muted">Images will be saved in: images/slides</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-section">
                                        <label>Slide 3</label>
                                        <div class="form-group">
                                            <label for="slide3_title">Title</label>
                                            <input type="text" class="form-control" id="slide3_title" name="content[site.hero.slide3.title]" value="{{ get_website_content('site.hero.slide3.title') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="slide3_subtitle">Subtitle</label>
                                            <input type="text" class="form-control" id="slide3_subtitle" name="content[site.hero.slide3.subtitle]" value="{{ get_website_content('site.hero.slide3.subtitle') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="slide3_image">Image</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="slide3_image" name="images[site.hero.slide3.image]">
                                                <label class="custom-file-label" for="slide3_image">Choose image</label>
                                            </div>
                                            <div class="mt-2">
                                                @if(get_website_content('site.hero.slide3.image'))
                                                    <div class="slider-preview">
                                                        <img src="{{ asset(get_website_content('site.hero.slide3.image')) }}" class="img-thumbnail" style="max-height: 100px">
                                                    </div>
                                                @endif
                                                <small class="form-text text-muted">Images will be saved in: images/slides</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary save-btn">Save Home Settings</button>
                            </form>
                        </div>

                        <!-- About Us Tab Content -->
                        <div class="tab-pane fade content-section" id="about" role="tabpanel" aria-labelledby="about-tab">
                            <h5 class="mb-4">About Us Page Settings</h5>
                            <form id="about-form" method="POST" action="{{ route('admin.web-template.update') }}">
                                @csrf
                                <input type="hidden" name="section" value="about">
                                
                                <div class="form-group">
                                    <label for="about_hero_title">Hero Title</label>
                                    <input type="text" class="form-control" id="about_hero_title" name="content[about.hero.title]" value="{{ get_website_content('about.hero.title') }}">
                                </div>
                                
                                <div class="form-group">
                                    <label for="about_hero_description">Hero Description</label>
                                    <textarea class="form-control" id="about_hero_description" name="content[about.hero.description]" rows="3">{{ get_website_content('about.hero.description') }}</textarea>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4 form-section">
                                        <div class="form-group">
                                            <label for="about_mission_title">Mission Title</label>
                                            <input type="text" class="form-control" id="about_mission_title" name="content[about.mission.title]" value="{{ get_website_content('about.mission.title') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="about_mission_content">Mission Content</label>
                                            <textarea class="form-control" id="about_mission_content" name="content[about.mission.content]" rows="4">{{ get_website_content('about.mission.content') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-section">
                                        <div class="form-group">
                                            <label for="about_vision_title">Vision Title</label>
                                            <input type="text" class="form-control" id="about_vision_title" name="content[about.vision.title]" value="{{ get_website_content('about.vision.title') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="about_vision_content">Vision Content</label>
                                            <textarea class="form-control" id="about_vision_content" name="content[about.vision.content]" rows="4">{{ get_website_content('about.vision.content') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-section">
                                        <div class="form-group">
                                            <label for="about_values_title">Values Title</label>
                                            <input type="text" class="form-control" id="about_values_title" name="content[about.values.title]" value="{{ get_website_content('about.values.title') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="about_values_content">Values Content</label>
                                            <textarea class="form-control" id="about_values_content" name="content[about.values.content]" rows="4">{{ get_website_content('about.values.content') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary save-btn">Save About Settings</button>
                            </form>
                        </div>

                        <!-- Donor List Tab Content -->
                        <div class="tab-pane fade content-section" id="donors" role="tabpanel" aria-labelledby="donors-tab">
                            <h5 class="mb-4">Donor List Page Settings</h5>
                            <form id="donors-form" method="POST" action="{{ route('admin.web-template.update') }}">
                                @csrf
                                <input type="hidden" name="section" value="donors">
                                
                                <div class="form-group">
                                    <label for="donors_per_page">Donors Per Page</label>
                                    <input type="number" class="form-control" id="donors_per_page" name="content[donors.per_page]" value="{{ get_website_content('donors.per_page') }}">
                                </div>
                                
                                <button type="submit" class="btn btn-primary save-btn">Save Donor List Settings</button>
                            </form>
                        </div>

                        <!-- Gallery Tab Content -->
                        <div class="tab-pane fade content-section" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                            <h5 class="mb-4">Gallery Page Settings</h5>
                            <form id="gallery-form" method="POST" action="{{ route('admin.web-template.update') }}">
                                @csrf
                                <input type="hidden" name="section" value="gallery">
                                
                                <div class="form-group">
                                    <label for="gallery_title">Gallery Title</label>
                                    <input type="text" class="form-control" id="gallery_title" name="content[gallery.title]" value="{{ get_website_content('gallery.title') }}">
                                </div>
                                
                                <div class="form-group">
                                    <label for="gallery_description">Gallery Description</label>
                                    <textarea class="form-control" id="gallery_description" name="content[gallery.description]" rows="3">{{ get_website_content('gallery.description') }}</textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="gallery_per_page">Images Per Page</label>
                                    <input type="number" class="form-control" id="gallery_per_page" name="content[gallery.per_page]" value="{{ get_website_content('gallery.per_page') }}">
                                </div>
                                
                                <button type="submit" class="btn btn-primary save-btn">Save Gallery Settings</button>
                            </form>
                        </div>

                        <!-- Emergency Tab Content -->
                        <div class="tab-pane fade content-section" id="emergency" role="tabpanel" aria-labelledby="emergency-tab">
                            <h5 class="mb-4">Emergency Page Settings</h5>
                            <form id="emergency-form" method="POST" action="{{ route('admin.web-template.update') }}">
                                @csrf
                                <input type="hidden" name="section" value="emergency">
                                
                                <div class="form-group">
                                    <label for="emergency_title">Page Title</label>
                                    <input type="text" class="form-control" id="emergency_title" name="content[emergency.title]" value="{{ get_website_content('emergency.title') }}">
                                </div>
                                
                                <div class="form-group">
                                    <label for="emergency_description">Page Description</label>
                                    <textarea class="form-control" id="emergency_description" name="content[emergency.description]" rows="3">{{ get_website_content('emergency.description') }}</textarea>
                                </div>
                                
                                <h6 class="mt-4">Emergency Hotlines</h6>
                                @for ($i = 1; $i <= 3; $i++)
                                @php
                                    $hotline = json_decode(get_website_content("emergency.hotline.{$i}"), true);
                                @endphp
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h6>Hotline {{ $i }}</h6>
                                        <div class="form-group">
                                            <label for="hotline_{{ $i }}_name">Organization Name</label>
                                            <input type="text" class="form-control" id="hotline_{{ $i }}_name" name="json[emergency.hotline.{{ $i }}][name]" value="{{ $hotline['name'] ?? '' }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="hotline_{{ $i }}_description">Description</label>
                                            <input type="text" class="form-control" id="hotline_{{ $i }}_description" name="json[emergency.hotline.{{ $i }}][description]" value="{{ $hotline['description'] ?? '' }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="hotline_{{ $i }}_phone">Phone Number</label>
                                            <input type="text" class="form-control" id="hotline_{{ $i }}_phone" name="json[emergency.hotline.{{ $i }}][phone]" value="{{ $hotline['phone'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                @endfor
                                
                                <button type="submit" class="btn btn-primary save-btn">Save Emergency Settings</button>
                            </form>
                        </div>

                        <!-- Milestones Tab Content -->
                        <div class="tab-pane fade content-section" id="milestones" role="tabpanel" aria-labelledby="milestones-tab">
                            <h5 class="mb-4">Milestones Management</h5>
                            <p class="text-muted">Add and manage milestones to showcase your organization's journey</p>
                            
                            <!-- Current Milestones -->
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered table-hover" id="milestoneTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Year</th>
                                            <th>Description</th>
                                            <th width="100">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $milestones = \App\Models\WebsiteContent::where('key', 'like', 'about.milestone.%')
                                            ->where('is_active', true)
                                            ->get()
                                            ->map(function($item) {
                                                $item->year = (int)str_replace('about.milestone.', '', $item->key);
                                                return $item;
                                            })
                                            ->sortByDesc('year')
                                            ->values();
                                        @endphp
                                        
                                        @if($milestones->count() > 0)
                                            @foreach($milestones as $milestone)
                                                <tr>
                                                    <td>{{ $milestone->year }}</td>
                                                    <td>{{ $milestone->content }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-primary edit-milestone" 
                                                            data-id="{{ $milestone->id }}" 
                                                            data-year="{{ $milestone->year }}" 
                                                            data-content="{{ $milestone->content }}">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger delete-milestone" 
                                                            data-id="{{ $milestone->id }}">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" class="text-center">No milestones found. Add your first milestone below.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Add/Edit Milestone Form -->
                            <div class="card milestone-card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0" id="milestoneFormTitle">Add New Milestone</h6>
                                </div>
                                <div class="card-body">
                                    <form id="milestoneForm" action="{{ route('admin.milestone.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" id="milestoneId" name="milestone_id">
                                        
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="milestoneYear">Year <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="milestoneYear" name="milestone_year" min="1900" max="2100" value="{{ date('Y') }}" required>
                                                <small class="form-text text-muted">Enter a year between 1900-2100</small>
                                            </div>
                                            <div class="form-group col-md-9">
                                                <label for="milestoneContent">Description <span class="text-danger">*</span></label>
                                                <textarea class="form-control" id="milestoneContent" name="milestone_content" rows="2" required></textarea>
                                                <small class="form-text text-muted">Provide a brief description of the milestone</small>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group mb-0 text-right">
                                            <button type="button" id="cancelMilestone" class="btn btn-secondary" style="display:none;">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Save Milestone</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle mr-2"></i> Milestones will be displayed on the About page of your website in chronological order.
                            </div>
                        </div>

                        <!-- Team Tab Content -->
                        <div class="tab-pane fade content-section" id="team" role="tabpanel" aria-labelledby="team-tab">
                            <h5 class="mb-4">Team Members</h5>
                            <p class="text-muted">Add and manage team members that will appear on your website</p>
                            
                            <!-- Add New Team Member Button -->
                            <div class="text-right mb-4">
                                <button id="addNewTeamBtn" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Add New Team Member
                                </button>
                            </div>
                            
                            <!-- Current Team Members -->
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered table-hover" id="teamTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th width="80">Image</th>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Description</th>
                                            <th width="100">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $teamMembers = \App\Models\WebsiteContent::where('key', 'like', 'about.team.member.%')
                                            ->where('is_active', true)
                                            ->get();
                                            
                                        $teamMembersData = [];
                                        foreach ($teamMembers as $member) {
                                            $memberData = json_decode($member->content, true);
                                            if ($memberData) {
                                                $memberData['id'] = $member->id;
                                                $teamMembersData[] = $memberData;
                                            }
                                        }
                                        @endphp
                                        
                                        @if(count($teamMembersData) > 0)
                                            @foreach($teamMembersData as $member)
                                                <tr>
                                                    <td class="text-center">
                                                        <img src="{{ asset($member['image']) }}" alt="{{ $member['name'] }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                                    </td>
                                                    <td>{{ $member['name'] }}</td>
                                                    <td>{{ $member['position'] }}</td>
                                                    <td>{{ $member['bio'] }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-primary edit-team" 
                                                            data-id="{{ $member['id'] }}" 
                                                            data-name="{{ $member['name'] }}" 
                                                            data-position="{{ $member['position'] }}"
                                                            data-description="{{ $member['bio'] }}"
                                                            data-image="{{ $member['image'] }}"
                                                            data-facebook="{{ $member['social']['facebook'] ?? '#' }}"
                                                            data-twitter="{{ $member['social']['twitter'] ?? '#' }}"
                                                            data-linkedin="{{ $member['social']['linkedin'] ?? '#' }}">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger delete-team" 
                                                            data-id="{{ $member['id'] }}">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">No team members found. Add your first team member below.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Add/Edit Team Member Form -->
                            <div class="card team-card mb-4" id="teamFormCard" style="display: none;">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0" id="teamFormTitle">Add New Team Member</h6>
                                </div>
                                <div class="card-body">
                                    <form id="teamForm" action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" id="teamId" name="team_id">
                                        
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="teamName">Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="teamName" name="team_name" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="teamPosition">Position <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="teamPosition" name="team_position" required>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="teamDescription">Bio</label>
                                            <textarea class="form-control" id="teamDescription" name="team_description" rows="3"></textarea>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="teamImage">Profile Image</label>
                                            <input type="file" class="form-control-file" id="teamImage" name="team_image" accept="image/*">
                                            <small class="form-text text-muted">Recommended size: 400x500 pixels. Max file size: 2MB.</small>
                                            <div id="currentImageContainer" style="display: none; margin-top: 10px;">
                                                <div class="card p-2" style="max-width: 150px;">
                                                    <img id="currentTeamImage" src="" alt="Team Member" style="width: 100%; object-fit: cover; border-radius: 4px;">
                                                    <div class="text-center mt-2">
                                                        <small class="text-muted">Current Image</small>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="currentImagePath" name="current_image_path">
                                            </div>
                                        </div>
                                        
                                        <div class="card mb-3">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">Social Media Links</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <label for="teamFacebook">Facebook</label>
                                                        <input type="url" class="form-control" id="teamFacebook" name="team_facebook" placeholder="https://facebook.com/username">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="teamTwitter">Twitter</label>
                                                        <input type="url" class="form-control" id="teamTwitter" name="team_twitter" placeholder="https://twitter.com/username">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="teamLinkedin">LinkedIn</label>
                                                        <input type="url" class="form-control" id="teamLinkedin" name="team_linkedin" placeholder="https://linkedin.com/in/username">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group mb-0 text-right">
                                            <button type="button" id="cancelTeam" class="btn btn-secondary" style="display:none;">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Save Team Member</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle mr-2"></i> Team members will be displayed on the About page of your website.
                            </div>
                        </div>

                        <!-- Contact Tab Content -->
                        <div class="tab-pane fade content-section" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <h5 class="mb-4">Contact Page Settings</h5>
                            <form id="contact-form" method="POST" action="{{ route('admin.web-template.update') }}">
                                @csrf
                                <input type="hidden" name="section" value="contact">
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="contact_title">Page Title</label>
                                        <input type="text" class="form-control" id="contact_title" name="content[contact.title]" value="{{ get_website_content('contact.title') }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="contact_subtitle">Page Subtitle</label>
                                        <input type="text" class="form-control" id="contact_subtitle" name="content[contact.subtitle]" value="{{ get_website_content('contact.subtitle') }}">
                                    </div>
                                </div>
                                
                                <h6 class="mt-4">Contact Information</h6>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="contact_info_title">Organization Title</label>
                                        <input type="text" class="form-control" id="contact_info_title" name="content[contact.info.title]" value="{{ get_website_content('contact.info.title') }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="contact_info_tagline">Tagline</label>
                                        <input type="text" class="form-control" id="contact_info_tagline" name="content[contact.info.tagline]" value="{{ get_website_content('contact.info.tagline') }}">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="contact_info_address">Address</label>
                                    <input type="text" class="form-control" id="contact_info_address" name="content[contact.info.address]" value="{{ get_website_content('contact.info.address') }}">
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="contact_info_phone">Phone</label>
                                        <input type="text" class="form-control" id="contact_info_phone" name="content[contact.info.phone]" value="{{ get_website_content('contact.info.phone') }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="contact_info_email">Email</label>
                                        <input type="email" class="form-control" id="contact_info_email" name="content[contact.info.email]" value="{{ get_website_content('contact.info.email') }}">
                                    </div>
                                </div>
                                
                         
                                
                                <div class="form-group">
                                    <label for="contact_map_iframe">Google Map Embed HTML</label>
                                    <textarea class="form-control" id="contact_map_iframe" name="content[contact.map_iframe]" rows="5">{{ get_website_content('contact.map_iframe') }}</textarea>
                                    <small class="form-text text-muted">Paste the complete iframe HTML code from Google Maps.</small>
                                </div>
                                
                                <button type="submit" class="btn btn-primary save-btn">Save Contact Settings</button>
                            </form>
                        </div>

                        <!-- General Tab Content -->
                        <div class="tab-pane fade content-section" id="general" role="tabpanel" aria-labelledby="general-tab">
                            <h5 class="mb-4">General Settings</h5>
                            <form id="general-form" method="POST" action="{{ route('admin.web-template.update') }}">
                                @csrf
                                <input type="hidden" name="section" value="general">
                                
                                <div class="form-group">
                                    <label for="sponsors_limit">Number of Sponsors to Show</label>
                                    <input type="number" class="form-control" id="sponsors_limit" name="content[site.sponsors.limit]" value="{{ get_website_content('site.sponsors.limit') }}">
                                </div>
                                
                                <div class="form-group">
                                    <label for="testimonials_limit">Number of Testimonials to Show</label>
                                    <input type="number" class="form-control" id="testimonials_limit" name="content[site.testimonials.limit]" value="{{ get_website_content('site.testimonials.limit') }}">
                                </div>
                                
                                <h5 class="mt-4 mb-3">Social Media Links</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="social_facebook">Facebook</label>
                                            <input type="text" class="form-control" id="social_facebook" name="content[social.facebook]" value="{{ get_website_content('social.facebook') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="social_twitter">Twitter</label>
                                            <input type="text" class="form-control" id="social_twitter" name="content[social.twitter]" value="{{ get_website_content('social.twitter') }}">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="social_instagram">Instagram</label>
                                            <input type="text" class="form-control" id="social_instagram" name="content[social.instagram]" value="{{ get_website_content('social.instagram') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="social_linkedin">LinkedIn</label>
                                            <input type="text" class="form-control" id="social_linkedin" name="content[social.linkedin]" value="{{ get_website_content('social.linkedin') }}">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="social_youtube">YouTube</label>
                                            <input type="text" class="form-control" id="social_youtube" name="content[social.youtube]" value="{{ get_website_content('social.youtube') }}">
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary save-btn">Save General Settings</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Set up CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Keep the selected tab active after form submission
        let activeTab = localStorage.getItem('activeWebsiteContentTab');
        if (activeTab) {
            $('#websiteContentTabs a[href="' + activeTab + '"]').tab('show');
        }

        $('#websiteContentTabs a').on('shown.bs.tab', function (e) {
            localStorage.setItem('activeWebsiteContentTab', $(e.target).attr('href'));
        });
        
        // Custom file input label update
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName || 'Choose image');
            
            // Preview image if file is selected
            if (this.files && this.files[0]) {
                const preview = $(this).closest('.form-group').find('.slider-preview img');
                if (preview.length) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                } else {
                    // Create preview if it doesn't exist
                    const previewContainer = $('<div class="slider-preview mt-2"><img src="" class="img-thumbnail" style="max-height: 100px"></div>');
                    $(this).closest('.form-group').find('.mt-2').prepend(previewContainer);
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewContainer.find('img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
                
                // Show a success message that the image has been selected
                let infoMessage = $('<div class="alert alert-info mt-2 image-selected-alert" style="display:none;"><i class="fa fa-info-circle"></i> New image selected. Save form to update.</div>');
                if (!$(this).closest('.form-group').find('.image-selected-alert').length) {
                    $(this).closest('.form-group').append(infoMessage);
                    infoMessage.fadeIn();
                }
            }
        });

        // Add/Edit milestone functionality
        $('.edit-milestone').on('click', function() {
            var id = $(this).data('id');
            var year = $(this).data('year');
            var content = $(this).data('content');
            
            // Fill form with milestone data
            $('#milestoneId').val(id);
            $('#milestoneYear').val(year);
            $('#milestoneContent').val(content);
            
            // Change form title and show cancel button
            $('#milestoneFormTitle').text('Edit Milestone');
            $('#cancelMilestone').show();
            $('#milestoneForm').attr('action', "{{ route('admin.milestone.update') }}");
            
            // Scroll to form
            $('html, body').animate({
                scrollTop: $('#milestoneForm').offset().top - 100
            }, 500);
        });
        
        // Cancel edit
        $('#cancelMilestone').on('click', function() {
            // Reset form
            $('#milestoneForm')[0].reset();
            $('#milestoneId').val('');
            $('#milestoneYear').val(new Date().getFullYear()); // Reset to current year
            
            // Change form title and hide cancel button
            $('#milestoneFormTitle').text('Add New Milestone');
            $(this).hide();
            $('#milestoneForm').attr('action', "{{ route('admin.milestone.store') }}");
        });
        
        // Delete milestone with AJAX
        $('.delete-milestone').on('click', function() {
            if (confirm('Are you sure you want to delete this milestone?')) {
                var id = $(this).data('id');
                var row = $(this).closest('tr');
                
                // Send delete request
                $.ajax({
                    url: "{{ route('admin.milestone.delete') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        milestone_id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            // Remove the row from the table
                            row.fadeOut(300, function() {
                                $(this).remove();
                                
                                // If no more rows, show empty message
                                if ($('#milestoneTable tbody tr').length === 0) {
                                    $('#milestoneTable tbody').html('<tr><td colspan="3" class="text-center">No milestones found. Add your first milestone below.</td></tr>');
                                }
                                
                                // Show success message
                                alert('Milestone deleted successfully');
                            });
                        } else {
                            alert('Failed to delete milestone: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        alert('An error occurred while trying to delete the milestone. Please try again.');
                    }
                });
            }
        });
        
        // Form validation and submission handling
        $('#milestoneForm').on('submit', function(e) {
            // Prevent default form submission
            e.preventDefault();
            
            // Get form data
            var formData = $(this).serialize();
            var actionUrl = $(this).attr('action');
            var isEdit = actionUrl.includes('update');
            
            // Send AJAX request
            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Reload the page to show updated milestone list
                        window.location.reload();
                    } else {
                        alert(response.message || 'Operation failed. Please try again.');
                    }
                },
                error: function(xhr) {
                    // Handle validation errors
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var errorMsg = 'Please fix the following errors:\n';
                        
                        for (var field in errors) {
                            errorMsg += '- ' + errors[field][0] + '\n';
                        }
                        
                        alert(errorMsg);
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                }
            });
        });
        
        // Show Team Member Form when Add New button is clicked
        $('#addNewTeamBtn').on('click', function() {
            // Reset the form to initial state
            resetTeamForm();
            
            // Show the form
            $('#teamFormCard').slideDown();
            
            // Scroll to form
            $('html, body').animate({
                scrollTop: $('#teamFormCard').offset().top - 100
            }, 500);
        });
        
        // Function to reset team form to initial state
        function resetTeamForm() {
            $('#teamForm')[0].reset();
            $('#teamId').val('');
            $('#currentImageContainer').hide();
            $('#teamFormTitle').text('Add New Team Member');
            $('#cancelTeam').hide();
            $('#teamForm').attr('action', "{{ route('admin.team.store') }}");
        }
        
        // Add/Edit team member functionality
        $('.edit-team').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var position = $(this).data('position');
            var description = $(this).data('description');
            var imagePath = $(this).data('image');
            var facebook = $(this).data('facebook');
            var twitter = $(this).data('twitter');
            var linkedin = $(this).data('linkedin');
            
            // First reset the form
            resetTeamForm();
            
            // Fill form with team member data
            $('#teamId').val(id);
            $('#teamName').val(name);
            $('#teamPosition').val(position);
            $('#teamDescription').val(description);
            
            // Handle image preview
            if (imagePath && imagePath !== 'images/team/placeholder.jpg') {
                $('#currentImageContainer').show();
                $('#currentTeamImage').attr('src', '{{ asset("") }}/' + imagePath);
                $('#currentImagePath').val(imagePath);
            } else {
                $('#currentImageContainer').hide();
            }
            
            // Fill social media links
            $('#teamFacebook').val(facebook || '#');
            $('#teamTwitter').val(twitter || '#');
            $('#teamLinkedin').val(linkedin || '#');
            
            // Change form title and show cancel button
            $('#teamFormTitle').text('Edit Team Member');
            $('#cancelTeam').show();
            $('#teamForm').attr('action', "{{ route('admin.team.update') }}");
            
            // Show the form
            $('#teamFormCard').slideDown();
            
            // Scroll to form
            $('html, body').animate({
                scrollTop: $('#teamFormCard').offset().top - 100
            }, 500);
        });
        
        // Cancel team edit
        $('#cancelTeam').on('click', function() {
            // Hide the form
            $('#teamFormCard').slideUp();
            
            // Reset form
            resetTeamForm();
        });
        
        // Delete team member with AJAX
        $('.delete-team').on('click', function() {
            if (confirm('Are you sure you want to delete this team member?')) {
                var id = $(this).data('id');
                var row = $(this).closest('tr');
                var button = $(this);
                
                // Show loading state
                var originalHtml = button.html();
                button.html('<i class="fa fa-spinner fa-spin"></i>');
                button.prop('disabled', true);
                
                // Send delete request
                $.ajax({
                    url: "{{ route('admin.team.delete') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        team_id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            // Remove the row from the table
                            row.fadeOut(300, function() {
                                $(this).remove();
                                
                                // If no more rows, show empty message
                                if ($('#teamTable tbody tr').length === 0) {
                                    $('#teamTable tbody').html('<tr><td colspan="5" class="text-center">No team members found. Add your first team member below.</td></tr>');
                                }
                                
                                // Show success message
                                alert('Team member deleted successfully');
                            });
                        } else {
                            // Reset button
                            button.html(originalHtml);
                            button.prop('disabled', false);
                            
                            alert('Failed to delete team member: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        // Reset button
                        button.html(originalHtml);
                        button.prop('disabled', false);
                        
                        console.error(xhr);
                        alert('An error occurred while trying to delete the team member. Please try again.');
                    }
                });
            }
        });
        
        // Team form validation and submission handling
        $('#teamForm').on('submit', function(e) {
            // Prevent default form submission
            e.preventDefault();
            
            // Get form data with file upload support
            var formData = new FormData(this);
            var actionUrl = $(this).attr('action');
            
            // Show loading indicator
            var submitBtn = $(this).find('button[type="submit"]');
            var originalBtnText = submitBtn.html();
            submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Saving...');
            submitBtn.prop('disabled', true);
            
            // Send AJAX request
            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Reset button
                    submitBtn.html(originalBtnText);
                    submitBtn.prop('disabled', false);
                    
                    if (response.success) {
                        // Show success message
                        alert('Team member saved successfully!');
                        
                        // Hide the form
                        $('#teamFormCard').slideUp();
                        
                        // Reset form
                        resetTeamForm();
                        
                        // Reload the page to show updated team member list
                        window.location.reload();
                    } else {
                        alert(response.message || 'Operation failed. Please try again.');
                    }
                },
                error: function(xhr) {
                    // Reset button
                    submitBtn.html(originalBtnText);
                    submitBtn.prop('disabled', false);
                    
                    // Handle validation errors
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var errorMsg = 'Please fix the following errors:\n';
                        
                        for (var field in errors) {
                            errorMsg += '- ' + errors[field][0] + '\n';
                        }
                        
                        alert(errorMsg);
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                }
            });
        });

        // Image preview functionality
        $('#teamImage').on('change', function() {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    $('#currentImageContainer').show();
                    $('#currentTeamImage').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        });
    });
</script>
@endsection 