<!-- filepath: c:\xampp\htdocs\one2one4\resources\views\contact.blade.php -->
@extends('layouts.layout')

@section('title', 'Contact Us') <!-- Updated title name -->

@section('public_content') <!-- Updated section name -->



      <div class="contact_section layout_padding">
         <div class="text-center">
             <h1 class="contact_heading">🚨 Emergency Contact</h1>
             <p class="contact_subtext">We are available 24/7 for urgent assistance</p>
         </div>
     
         <div class="container">
             <div class="row justify-content-center mt-4">
                 <!-- 911 Emergency -->
                 <div class="col-lg-3 col-md-6">
                     <div class="contact_card">
                         <i class="fas fa-phone-alt contact_icon"></i>
                         <h4>General Emergency</h4>
                         <p>
                             <a href="tel:911">Call 999</a>
                         </p>
                     </div>
                 </div>
     
                 <!-- Fire Services -->
                 <div class="col-lg-3 col-md-6">
                     <div class="contact_card">
                         <!-- <i class="fas fa-fire-extinguisher contact_icon"></i> -->
                         <h4>Fire Services</h4>
                         <p>
                             <a href="tel:101">Call 101</a>
                         </p>
                     </div>
                 </div>
     
                 <!-- Police Assistance -->
                 <div class="col-lg-3 col-md-6">
                     <div class="contact_card">
                         <i class="fas fa-shield-alt contact_icon"></i>
                         <h4>Police Assistance</h4>
                         <p>
                             <a href="tel:102">Call 102</a>
                         </p>
                     </div>
                 </div>
     
                 <!-- Medical Emergency -->
                 <div class="col-lg-3 col-md-6">
                     <div class="contact_card">
                         <!-- <i class="fas fa-ambulance contact_icon"></i> -->
                         <h4>Medical Emergency</h4>
                         <p>
                             <a href="tel:103">Call 103</a>
                         </p>
                     </div>
                 </div>
     
                 <!-- Internal Emergency Contacts -->
                 <div class="col-lg-3 col-md-6">
                     <div class="contact_card">
                         <i class="fas fa-user-shield contact_icon"></i>
                         <h4>Internal Emergency</h4>
                         <p>
                             <a href="tel:+1234567890">+1 234 567 890</a> <br>
                             <a href="tel:+0987654321">+0 987 654 321</a>
                         </p>
                     </div>
                 </div>
                 <div class="col-lg-3 col-md-6">
                  <div class="contact_card">
                      <i class="fas fa-user-shield contact_icon"></i>
                      <h4>Internal Emergency</h4>
                      <p>
                          <a href="tel:+1234567890">+1 234 567 890</a> <br>
                          <a href="tel:+0987654321">+0 987 654 321</a>
                      </p>
                  </div>
              </div>
             </div>
         </div>
     </div>
     

@endsection

@push('scripts')
      <!-- javascript --> 
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