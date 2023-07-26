<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('includes.header')
    <!-- vendor css -->
    @include('includes.css')
    
  </head>

  <body class="bg-white font-family-karla">
    
    <div>
        @include('includes.navbar')
        <!-- ########## START: MAIN PANEL ########## -->
        @yield('body-content')
        @include('includes.footer')
        <!-- ########## END: MAIN PANEL ########## -->
    </div>
    @include('includes.script')
    @include('includes.toastify')

  </body>
</html>