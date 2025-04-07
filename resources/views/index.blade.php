<!-- filepath: c:\xampp\htdocs\one2one4\resources\views\index.blade.php -->
@extends('layouts.layout')

@section('title', 'Home')

@section('public_content') <!-- Updated section name -->



       
         <!-- banner section start --> 
         <div class="banner_section layout_padding">
            <div class="container">
               <div class="row">
                  <!-- <div class="col-md-6">
                     <h1 class="banner_taital">রক্তের সন্ধানে এসএসসি ২০১২ ও এইচএসসি ২০১৪ ব্যাচ, ওয়েবসাইটে আপনাকে স্বাগতম।  <span style="color: #2b2b2b;">ওয়েবসাইট এর  কাজ চলছে সাময়িক অসুবিধার জন্য আমরা দু:খিত।</span></h1>
                     <p class="banner_text">রক্ত দিন জীবন বাচান</p>
                  </div> -->
                  <div class="col-md-8 mx-auto">
                     <div id="banner_slider" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                               <div class="banner_img"><img src="{{ asset('images/banner-img.png') }}"></div>
                            </div>
                            <div class="carousel-item">
                               <div class="banner_img"><img src="{{ asset('images/banner-img1.jpg') }}"></div>
                            </div>
                            <div class="carousel-item">
                               <div class="banner_img"><img src="{{ asset('images/banner-img2.jpg') }}"></div>
                            </div>
                            <div class="carousel-item">
                               <div class="banner_img"><img src="{{ asset('images/banner-img3.png') }}"></div>
                            </div>
                            <div class="carousel-item">
                               <div class="banner_img"><img src="{{ asset('images/banner-img4.png') }}"></div>
                            </div>
                         </div>
                        <a class="carousel-control-prev" href="#banner_slider" role="button" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                        </a>
                        <a class="carousel-control-next" href="#banner_slider" role="button" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- banner section end -->
      </div>
      <!-- header section end -->
      
      <!-- select box section start -->
      <div class="container">
         <div class="select_box_section" style="background: linear-gradient(135deg, #560505, #3C0606); padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgb(255, 255, 255);">
             <div class="select_box_main">
                 <div class="row">
                     <div class="col-md-3 select-outline">
                         <input type="text" class="enter_bt" placeholder="Enter Keywords" name="Enter Keywords" 
                             style="width: 100%; padding: 10px; border-radius: 5px; border: none; outline: none;">
                     </div>
                     
                     <div class="col-md-3 select-outline">
                         <select class="mdb-select md-form md-outline colorful-select dropdown-primary" 
                             style="width: 100%; padding: 10px; border-radius: 5px; border: none; outline: none;">
                             <option value="" disabled selected>Blood Categories</option>
                             <option value="1">A+</option>
                             <option value="2">A-</option>
                             <option value="3">B+</option>
                             <option value="4">B-</option>
                             <option value="5">O+</option>
                             <option value="6">O-</option>
                             <option value="7">AB+</option>
                             <option value="8">AB-</option>
                         </select>
                     </div>
                     <div class="col-md-3 select-outline">
                        <select class="mdb-select md-form md-outline colorful-select dropdown-primary" 
                            style="width: 100%; padding: 10px; border-radius: 5px; border: none; outline: none;">
                            <option value="" disabled selected>Year of SSC</option>
                            <option value="1">2012</option>
                            <option value="2">2013</option>
                            <option value="3">2014</option>
                        </select>
                    </div>
                     <div class="col-md-3 select-outline">
                         <select class="mdb-select md-form md-outline colorful-select dropdown-primary" 
                             style="width: 100%; padding: 10px; border-radius: 5px; border: none; outline: none;">
                             <option value="" disabled selected>Thana/Upzila</option>
                             <option value="1">Option 1</option>
                             <option value="2">Option 2</option>
                             <option value="3">Option 3</option>
                         </select>
                     </div>
                    
                 </div>
             </div>
             <div class="text-center mt-3">
                 <a href="#" class="search_btn" style="background: #fff; color: #824b58; padding: 10px 20px; border-radius: 5px; font-weight: bold; text-decoration: none; display: inline-block; transition: 0.3s;">
                     Search Now
                 </a>
             </div>
         </div>
     </div>
     

      <!-- shop section start -->
      <div class="customer_section layout_padding">
         <div class="container">
             <div class="row">
                 <div class="col-md-12">
                     <h1 class="blog_taital">Live Donor Summary</h1>
                 </div>
                 <div class="carousel-inner">
                     <div class="carousel-item active">
                         <div class="container">
                             <div class="stat total-donors" 
                                 style="background: #e74c3c; color: white; padding: 50px; font-size: 28px; font-weight: bold; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); min-width: 200px; 
                                 animation: slideIn 1s ease-in-out, pulse 2s infinite alternate;">
                                 Total Donors: <span id="totalDonors">230</span>
                             </div>
     
                             <div class="stat available-donors" 
                                 style="background: #27ae60; color: white; padding: 50px; font-size: 28px; font-weight: bold; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); min-width: 200px; 
                                 animation: slideIn 1.2s ease-in-out, pulse 2s infinite alternate;">
                                 Available Donors: <span id="availableDonors">45</span>
                             </div>
     
                             <div class="stat total-donations" 
                                 style="background: #2980b9; color: white; padding: 50px; font-size: 28px; font-weight: bold; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); min-width: 200px; 
                                 animation: slideIn 1.5s ease-in-out, pulse 2s infinite alternate;">
                                 Total Donation: <span id="totalDonations">550</span>
                             </div>
                         </div>
                         <div class="info" 
                             style="text-align: center; font-size: 20px; font-weight: bold; color: #fff; background: linear-gradient(45deg, #e74c3c, #8a0303); padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); 
                             animation: fadeIn 2s ease-in-out;">
                             <h4 style="animation: pulse 1.5s infinite;">Blood donation saves lives! Join us and be a hero today.</h4>
                             <h4 style="animation: pulse 1.5s infinite 0.5s;">Every drop counts – help those in need by donating blood.</h4>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     
     <style>
         @keyframes slideIn {
             from { opacity: 0; transform: translateY(-20px); }
             to { opacity: 1; transform: translateY(0); }
         }
     
         @keyframes pulse {
             0% { transform: scale(1); }
             100% { transform: scale(1.05); }
         }
     
         @keyframes fadeIn {
             from { opacity: 0; transform: translateY(-10px); }
             to { opacity: 1; transform: translateY(0); }
         }
     </style>
     
      <!-- shop section end -->

   
      <!-- customer section end -->
      <div class="customer_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-sm-12">
                  <h1 class="customer_taital">WHAT IS SAYS OUR SURVIVOR HEROES AND FRIENDS</h1>
               </div>
            </div>
         </div>
         <div id="my_slider" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <div class="customer_section_2">
                     <div class="container">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="box_main">
                                 <div class="customer_main">
                                    <p class="enim_text">has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors </p>
                                    <div class="customer_left">
                                       <div class="customer_img"><img src="images/customer-img.png"></div>
                                    </div>
                                    <div class="customer_right">
                                       <h3 class="customer_name">Content</h3>
                                       <p class="web_text">And web page </p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="customer_section_2">
                     <div class="container">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="box_main">
                                 <div class="customer_main">
                                    <p class="enim_text">has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors </p>
                                    <div class="customer_left">
                                       <div class="customer_img"><img src="images/customer-img.png"></div>
                                    </div>
                                    <div class="customer_right">
                                       <h3 class="customer_name">Content</h3>
                                       <p class="web_text">And web page </p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="customer_section_2">
                     <div class="container">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="box_main">
                                 <div class="customer_main">
                                    <p class="enim_text">has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors </p>
                                    <div class="customer_left">
                                       <div class="customer_img"><img src="images/customer-img.png"></div>
                                    </div>
                                    <div class="customer_right">
                                       <h3 class="customer_name">Content</h3>
                                       <p class="web_text">And web page </p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <a class="carousel-control-prev" href="#my_slider" role="button" data-slide="prev">
            <i class="fa fa-angle-left"></i>
            </a>
            <a class="carousel-control-next" href="#my_slider" role="button" data-slide="next">
            <i class="fa fa-angle-right"></i>
            </a>
         </div>
      </div>
      <!-- customer section end -->


<!-- Sponsor section Start -->
<div class="sponsor_section layout_padding">
   <div class="container">
       <div class="row">
           <div class="col-sm-12">
               <h1 class="blog_taital" style="color: black;">OUR ESTEEMED SPONSORS</h1>
           </div>
       </div>
   </div>
   <div id="sponsor_slider" class="carousel slide" data-ride="carousel">
       <div class="carousel-inner">
           <div class="carousel-item active">
               <div class="sponsor_section_2">
                   <div class="container">
                       <div class="row">
                           <div class="col-md-2">
                               <div class="sponsor_main">
                                   <div class="sponsor_img">
                                       <img src="images/logo.jpeg" alt="Sponsor 1">
                                   </div>
                                   <h3 class="sponsor_name" style="color: #8A0000;">Company Name 1</h3>
                               </div>
                           </div>
                           <div class="col-md-2">
                               <div class="sponsor_main">
                                   <div class="sponsor_img">
                                       <img src="images/logo.jpeg" alt="Sponsor 2">
                                   </div>
                                   <h3 class="sponsor_name" style="color: #8A0000;">Company Name 2</h3>
                               </div>
                           </div>
                           <div class="col-md-2">
                               <div class="sponsor_main">
                                   <div class="sponsor_img">
                                       <img src="images/logo.jpeg" alt="Sponsor 3">
                                   </div>
                                   <h3 class="sponsor_name" style="color: #8A0000;">Company Name 3</h3>
                               </div>
                           </div>
                           <div class="col-md-2">
                               <div class="sponsor_main">
                                   <div class="sponsor_img">
                                       <img src="images/logo.jpeg" alt="Sponsor 4">
                                   </div>
                                   <h3 class="sponsor_name" style="color: #8A0000;">Company Name 4</h3>
                               </div>
                           </div>
                           <div class="col-md-2">
                               <div class="sponsor_main">
                                   <div class="sponsor_img">
                                       <img src="images/logo.jpeg" alt="Sponsor 5">
                                   </div>
                                   <h3 class="sponsor_name" style="color: #8A0000;">Company Name 5</h3>
                               </div>
                           </div>
                           <div class="col-md-2">
                               <div class="sponsor_main">
                                   <div class="sponsor_img">
                                       <img src="images/logo.jpeg" alt="Sponsor 6">
                                   </div>
                                   <h3 class="sponsor_name" style="color: #8A0000;">Company Name 6</h3>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           <div class="carousel-item">
               <div class="sponsor_section_2">
                   <div class="container">
                       <div class="row">
                           <div class="col-md-2">
                               <div class="sponsor_main">
                                   <div class="sponsor_img">
                                       <img src="images/logo.jpeg" alt="Sponsor 7">
                                   </div>
                                   <h3 class="sponsor_name" style="color: #8A0000;">Company Name 7</h3>
                               </div>
                           </div>
                           <div class="col-md-2">
                               <div class="sponsor_main">
                                   <div class="sponsor_img">
                                       <img src="images/logo.jpeg" alt="Sponsor 8">
                                   </div>
                                   <h3 class="sponsor_name" style="color: #8A0000;">Company Name 8</h3>
                               </div>
                           </div>
                           <div class="col-md-2">
                               <div class="sponsor_main">
                                   <div class="sponsor_img">
                                       <img src="images/logo.jpeg" alt="Sponsor 9">
                                   </div>
                                   <h3 class="sponsor_name" style="color: #8A0000;">Company Name 9</h3>
                               </div>
                           </div>
                           <div class="col-md-2">
                               <div class="sponsor_main">
                                   <div class="sponsor_img">
                                       <img src="images/logo.jpeg" alt="Sponsor 10">
                                   </div>
                                   <h3 class="sponsor_name" style="color: #8A0000;">Company Name 10</h3>
                               </div>
                           </div>
                           <div class="col-md-2">
                               <div class="sponsor_main">
                                   <div class="sponsor_img">
                                       <img src="images/logo.jpeg" alt="Sponsor 11">
                                   </div>
                                   <h3 class="sponsor_name" style="color: #8A0000;">Company Name 11</h3>
                               </div>
                           </div>
                           <div class="col-md-2">
                               <div class="sponsor_main">
                                   <div class="sponsor_img">
                                       <img src="images/logo.jpeg" alt="Sponsor 12">
                                   </div>
                                   <h3 class="sponsor_name" style="color: #8A0000;">Company Name 12</h3>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           <!-- You can continue adding more items here as necessary -->
       </div>
       <a class="carousel-control-prev" href="#sponsor_slider" role="button" data-slide="prev" 
          style="color: #8A0000; font-size: 30px; transition: color 0.3s ease;" 
          onmouseover="this.style.color='#B22222'" onmouseout="this.style.color='#8A0000'">
          <i class="fa fa-angle-left"></i>
       </a>
       <a class="carousel-control-next" href="#sponsor_slider" role="button" data-slide="next" 
          style="color: #8A0000; font-size: 30px; transition: color 0.3s ease;" 
          onmouseover="this.style.color='#B22222'" onmouseout="this.style.color='#8A0000'">
          <i class="fa fa-angle-right"></i>
       </a>
   </div>
</div>

      
 <!-- Sponsor section End -->

      <!-- contact section start -->
      <div class="contact_section layout_padding">
         <div class="row">
            <div class="col-sm-12">
               <h1 class="contact_taital contact_heading">Contact Us</h1>
            </div>
         </div>
         <div class="container">
           
            <div class="contact_section_2">
               <div class="row">
                  <div class="col-md-12">
                     <div class="mail_section map_form_container">
                        <form action="">
                           <input type="text" class="mail_text" placeholder="Your Name" name="Your Name">
                           <input type="text" class="mail_text" placeholder="Email" name="Email">
                           <textarea class="massage-bt" placeholder="Massage" rows="5" id="comment" name="Massage"></textarea>
                           <div class="contact_btn_main">
                              <div class="send_bt active"><a href="#">Send</a></div>
                              <div class="map_bt"><a href="#" id="showMap">Map</a></div>
                           </div>
                        </form>
                        <div class="map_main map_container">
                           <div class="map-responsive">
                              <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&amp;q=Eiffel+Tower+Paris+France" width="600" height="368" frameborder="0" style="border:0; width: 100%;" allowfullscreen=""></iframe>
                              <div class="btn_main">
                                 <div class="map_bt d-flex justify-content-center w-100 map_center"><a href="#" id="showForm">Form</a></div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- contact section end -->





@endsection

@push('scripts')
<script>
    function startCountdown(eventDate) {
        function updateCountdown() {
            const now = new Date().getTime();
            const distance = eventDate - now;
            
            if (distance < 0) {
                document.getElementById("countdown").innerHTML = "The event has started!";
                clearInterval(interval);
                return;
            }
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            document.getElementById("countdown").innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
        }
        
        updateCountdown(); 
        const interval = setInterval(updateCountdown, 1000);
    }
    
    const eventDate = new Date("2025-03-15T09:00:00").getTime();
    startCountdown(eventDate);
    
    function updateStatistics() {
        document.getElementById("totalDonors").innerText = 150;
        document.getElementById("availableDonors").innerText = 85;
    }
    
    updateStatistics();
</script>
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