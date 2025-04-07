
<!-- filepath: c:\xampp\htdocs\one2one4\resources\views\about.blade.php -->
@extends('layouts.layout')

@section('title', 'About Us') <!-- Updated title name -->

@section('public_content') <!-- Updated section name -->


      <!-- about section start -->
      <div class="about_section layout_padding">
         <div class="container-fluid">
            <div class="row">
               <!-- About Us Section -->
               <div class="col-md-6 padding_left0">
                  <div class="about_taital_main">
                     <h1 class="about_taital">About Us</h1>
                     <h6 class="about_text" style="text-align: justify; font-size: 16px; color: #555;">
                        We are dedicated to saving lives by bridging the gap between blood donors and those in urgent need. 
                        Our platform makes it easy to find nearby donation centers, schedule donations, and spread awareness about the importance of blood donation. 
                        Together, we can make a difference and give the gift of life.
                     </h6>
                     
                     <div class="btn_main">
                        <!-- <div class="started_bt"><a href="#">Get Started</a></div> -->
                        <div class="buy_bt "><a href="donation_form.html">Donate Now</a></div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="about_img"><img src="images/about-img.jpg" alt="Blood Donation Image"></div>
               </div>
      
               <!-- Mission Section -->
               <div class="col-md-12 padding_left0">
                  <div class="about_taital_main mission_vision_section">
                     <h1 class="about_taital">Our Mission</h1>
                     <p class="about_text1">To ensure that every patient has access to a safe and sufficient blood supply by connecting willing donors with hospitals, blood banks, 
                        and those in need. Through awareness campaigns, donor drives, and seamless digital solutions, we aim to make blood donation easy, accessible, 
                        and impactful.</p>
                  </div>
               </div>
      
               <!-- Vision Section -->
               <div class="col-md-12 padding_left0">
                  <div class="about_taital_main mission_vision_section">
                     <h1 class="about_taital">Our Vision</h1>
                     <p class="about_text1">To create a world where no one suffers due to a lack of blood. We envision a future where voluntary blood donation is a widely accepted 
                        practice, ensuring that hospitals and patients always have a reliable and adequate supply.</p>
                  </div>
               </div>


               
            </div>
         </div>
      </div>
      
      <!-- about section end -->
     
@endsection


@push('scripts') 
      <script>
         // Material Select Initialization
         $(document).ready(function() {
         $('.mdb-select').materialSelect();
         $('.select-wrapper.md-form.md-outline input.select-dropdown').bind('focus blur', function () {
         $(this).closest('.select-outline').find('label').toggleClass('active');
         $(this).closest('.select-outline').find('.caret').toggleClass('active');
         });
         });
      </script>
@endpush