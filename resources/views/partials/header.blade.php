<!-- filepath: c:\xampp\htdocs\one2one4\resources\views\partials\header.blade.php -->
<div class="header_section">
    <div class="container-fluid">
       <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="{{ route('home') }}">
           <img src="{{ asset('images/logo.jpeg') }}" style="width: 100px; height: auto;">
           </a>
             <div class="col-md-4">
                <p class="banner_text">একের কাঁধে অন্যের হাত, <br>১২/১৪ ব্যাচের রক্তের বাধন টিকে থাক</p>
                <h2 class="banner_taital">এসএসসি ১২ ও এইচএসসি ১৪ ব্যাচ</h2>
            </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('home') }}" style="color: #8a0303;">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about') }}" style="color: #8a0303;">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('donor.list') }}" style="color: #8a0303;">Donor List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('gallery') }}" style="color: #8a0303;">Gallery</a>
                </li>
                {{-- <li class="nav-item">
                   <a class="nav-link" href="{{ route('internal.program') }}" style="color: #8a0303;">Internal Program</a>
               </li> --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}" style="color: #8a0303;">Emergency Contact</a>
                </li>
            </ul>
            
            <!-- Add some hover effect using CSS -->
            <style>
                .navbar-nav .nav-link:hover {
                    color: #8a0303; /* Lighter red color on hover */
                }
            </style>
            
             <form class="form-inline my-2 my-lg-0">
                <div class="login_bt">
                   <ul style="list-style-type: none; padding: 0; display: flex; margin: 0;">
                      
                        {{-- <li class="active" style="margin-right: 15px;">
                            <a href="{{ route('login') }}" style="color: #8a0303; text-decoration: none;">Login</a>
                        </li> --}}
                        
                       <li class="active" style="margin-right: 15px;">
                        <a href="{{ route('register') }}" style="color: #8a0303; text-decoration: none;">Registration</a>
                    </li>
                   </ul>
               </div>
             </form>
          </div>
       </nav>
    </div> 
       <div class="notice-bar" style="background: #8a0303; color: white; font-weight: bold; padding: 10px 0; font-size: 18px;">
           <marquee behavior="scroll" direction="left">
           রক্তের সন্ধানে এসএসসি ২০১২ ও এইচএসসি ২০১৪ ব্যাচ, ওয়েবসাইটে আপনাকে স্বাগতম। ওয়েবসাইট এর কাজ চলছে সাময়িক অসুবিধার জন্য আমরা দু:খিত।
           </marquee>
       </div>
   </div>