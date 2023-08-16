<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('includes.app.header')
    <!-- vendor css -->
    @include('includes.app.css')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{asset('js/axios.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/config.js')}}"></script>
  </head>

  <body class="bg-white font-family-karla">
    
    <div class="container position-sticky z-index-sticky top-0">
      <div class="row">
        <div class="col-12">
        @include('includes.app.navbar')
        </div>
      </div>
    </div>

    <div id="loader" class="hidden w-full h-full fixed block top-0 left-0 bg-white opacity-75 z-50">
      <div class="mb-5 h-4 overflow-hidden rounded-full bg-gray-200">
        <div class="h-4 animate-pulse rounded-full bg-gradient-to-r from-green-500 to-blue-500" style="width: 100%"></div>
      </div>
    </div>

    <!-- ########## START: MAIN PANEL ########## -->
    <main class="main-content  mt-0">
      <section>
        <div class="page-header min-vh-75">
          <div class="container">
            @yield('body-content')
          </div>
        </div>
      </section>
    </main>
    <!-- ########## END: MAIN PANEL ########## -->
    
    @include('includes.app.footer')
    @include('includes.app.script')
    @include('includes.app.toastify')
  </body>
</html>