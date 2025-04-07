<!DOCTYPE html>
<html>
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>BLOOD TEAM</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
      <!-- Responsive-->
      <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
      <!-- fevicon -->
      <link rel="icon" href="{{ asset('images/fevicon.png') }}" type="image/gif" />
      <!-- font css -->
      <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400;700;800&display=swap" rel="stylesheet">
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="{{ asset('css/jquery.mCustomScrollbar.min.css') }}">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">

   </head>
   <body>
      <div class="header_section">
         <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <!-- <a class="navbar-brand"href="index.html"><img src="images/logo.jpeg"></a> -->
               <a class="navbar-brand" href="index.html">
                <img src="{{ asset('images/logo.jpeg') }}" style="width: 100px; height: auto;">
                </a>
                  <div class="col-md-4">
                     <p class="banner_text">একের কাঁধে অন্যের হাত, <br>১২/১৪ ব্যাচের রক্তের বাধন টিকে থাক</p>
                     <h2 class="banner_taital">এসএসসি ১২ ও এইচএসসি ১৪ ব্যাচ</h2>
                 </div>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent" >
                  <ul class="navbar-nav ml-auto">
                     <li class="nav-item active">
                         <a class="nav-link" href="index.html" style="color: #8a0303;">Home</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="about.html" style="color: #8a0303;">About Us</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="pricing.html" style="color: #8a0303;">Donor List</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="shop.html" style="color: #8a0303;">Gallery</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="internal_program.html" style="color: #8a0303;">Internal Program</a>
                    </li>
                     <!-- <li class="nav-item">
                         <a class="nav-link" href="services.html" style="color: #8a0303;">Services</a>
                     </li> -->
                     <li class="nav-item">
                         <a class="nav-link" href="contact.html" style="color: #8a0303;">Emergency Contact</a>
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
                            <li class="active" style="margin-right: 15px;">
                                <a href="become_a_donor.html" style="color: #8a0303; text-decoration: none;">Registration</a>
                            </li>
                            
                            <!-- <li style="margin-right: 15px;">
                                <a href="login.html" style="color: #8a0303; text-decoration: none;">Login</a>
                            </li> -->
                            <!-- <li><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li> -->
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

        
        <!-- <div class="notice-bar" style="background: #8a0303; color: white; font-weight: bold; padding: 10px 0; font-size: 28px;">
         <marquee behavior="scroll" direction="left">
            রক্তের সন্ধানে এসএসসি ২০১২ ও এইচএসসি ২০১৪ ব্যাচ, ওয়েবসাইট আপনাকে স্বাগতম। ওয়েবসাইট এর  কাজ চলছে সাময়িক অসুবিধার জন্য আমরা দু:খিত।
         </marquee>
     </div> -->
        
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
      <!-- footer section start -->
      <div class="footer_section layout_padding">
         <div class="row">
            <div class="col-md-12">
               <!-- <div class="footer_logo">
                  <img src="images/footer_logo.jpeg" style="width: 80px; height: auto; display: block; margin: 0 auto;">
              </div> -->
              <div style="text-align: center; margin-top: 20px;">
               <span style="font-size: 48px; font-weight: bold; color: white ;">OneTwoOneFour</span>
           </div>
            </div>
         </div>
         <div class="container">
            
      
               <div class="row">
                  <div class="col-lg-3 col-sm-6">
                     <h2 class="useful_text">Useful link </h2>
                     <div class="footer_menu">
                        <ul>
                           <li><a href="index.html">Home</a></li>
                           <li><a href="about.html">About</a></li>
                           <li><a href="services.html">Services</a></li>
                           <li><a href="sell.html">Sell</a></li>
                           <li><a href="products.html">Products</a></li>
                           <li><a href="contact.html">Contact Us</a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                     <h2 class="useful_text">Portfolio</h2>
                     <div class="footer_menu">
                        <ul>
                           <li><a href="#">LIodeno</a></li>
                           <li><a href="jokri.html">Jokri</a></li>
                           <li><a href="begana.html">Begana</a></li>
                           <li><a href="sell.html">Sell</a></li>
                           <li><a href="products.html">Products</a></li>
                           <li><a href="contact.html">Contact Us</a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                     <h2 class="useful_text">Contact Us</h2>
                     <div class="location_text"><img src="images/call-icon.png"><span class="padding_left_15"><a href="#">+01 1234567</a></span></div>
                     <div class="location_text"><img src="images/mail-icon.png"><span class="padding_left_15"><a href="#">demo@gmail.com</a></span></div>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                     <h2 class="useful_text">Social Link</h2>
                     <p class="footer_text">It is a long established fact that a reader will be </p>
                     <div class="social_icon">
                        <ul>
                           <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                           <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                           <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                           <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>

         </div>
     
      <!-- footer section end -->
      <!-- copyright section start -->
      <div class="copyright_section">
         <div class="container">
            <p class="copyright_text">2025 All Rights Reserved. Design by <a href="https://www.aioinnovation.com/">AiO Innovation Limited</a></p>
         </div>
      </div>
      <!-- copyright section end -->
      <!-- Javascript files-->
      <script src="{{ asset('js/jquery.min.js') }}"></script>
      <script src="{{ asset('js/popper.min.js') }}"></script>
      <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('js/jquery-3.0.0.min.js') }}"></script>
      <script src="{{ asset('js/plugin.js') }}"></script>
      <script src="{{ asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
      <script src="{{ asset('js/custom.js') }}"></script>
      <!-- javascript --> 
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
   </body>
</html>