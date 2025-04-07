<!-- filepath: c:\xampp\htdocs\one2one4\resources\views\layouts\layout.blade.php -->
<!DOCTYPE html>
<html>
   <head>
      <!-- Basic Meta Tags -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>@yield('title', 'Blood Team')</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">

      <!-- CSS Files -->
      <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
      <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
      <link rel="icon" href="{{ asset('images/fevicon.png') }}" type="image/gif" />
      <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400;700;800&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="{{ asset('css/jquery.mCustomScrollbar.min.css') }}">
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
   </head>
   <body>
      <!-- Header Section -->
      @include('partials.header')

      <!-- Main Content -->
      <div class="main-content">
        @yield('public_content')
      </div>

      <!-- Footer Section -->
      @include('partials.footer')

      <!-- JavaScript Files -->
      <script src="{{ asset('js/jquery.min.js') }}"></script>
      <script src="{{ asset('js/popper.min.js') }}"></script>
      <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('js/jquery-3.0.0.min.js') }}"></script>
      <script src="{{ asset('js/plugin.js') }}"></script>
      <script src="{{ asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
      <script src="{{ asset('js/custom.js') }}"></script>
      @stack('scripts')
   </body>
</html>