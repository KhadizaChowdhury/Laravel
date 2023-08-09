<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('includes.header')
    <!-- vendor css -->
    @include('includes.css')
    <script src="{{asset('js/toastify.js')}}"></script>
    {{-- 
    <script src="{{asset('js/axios.min.js')}}"></script> --}}
  </head>

  <body class="bg-white font-family-karla">
    
    <div>
      @include('includes.navbar')
        <div id="loader" class="hidden w-full h-full fixed block top-0 left-0 bg-white opacity-75 z-50">
          <div class="mb-5 h-4 overflow-hidden rounded-full bg-gray-200">
            <div class="h-4 animate-pulse rounded-full bg-gradient-to-r from-green-500 to-blue-500" style="width: 100%"></div>
          </div>
        </div>
        <!-- ########## START: MAIN PANEL ########## -->
        @yield('body-content')
        <!-- ########## END: MAIN PANEL ########## -->
    </div>
    @include('includes.footer')
    @include('includes.script')
    @include('includes.toastify')
  </body>
</html>