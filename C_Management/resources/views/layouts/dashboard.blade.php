<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
  <head>
    <!-- Required meta tags -->
    @include('includes.header')
    <!-- vendor css -->
    @include('includes.css')
    <script src="{{asset('js/toastify.js')}}"></script>
    <script src="{{asset('js/axios.min.js')}}"></script>
  </head>
  <body class="h-full">

    <div class="min-h-full">
      @include('includes.navbar')

      <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
          <div class="navbar bg-base-100">
          <div class="flex-none">
            <div class="drawer-content">
              <label for="my-drawer" class="btn drawer-button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                  </svg>
              </label>
            </div>
          </div>
          <div class="flex-1">
            <!-- Page content here -->
              <label class="ml-5 normal-case text-3xl font-bold tracking-tight text-gray-900">Dashboard</label>
          </div>
          </div>

        </div>
          
        </header>

      <!-- ########## START: MAIN PANEL ########## -->
        @include('includes.sidebar')
        <div id="loader" class="hidden w-full h-full fixed block top-0 left-0 bg-white opacity-75 z-50">
          <div class="mb-5 h-4 overflow-hidden rounded-full bg-gray-200">
            <div class="h-4 animate-pulse rounded-full bg-gradient-to-r from-green-500 to-blue-500" style="width: 100%"></div>
          </div>
        </div>
        <main>
          <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <!-- Your content -->
            @yield('dasboard-body-content')
          </div>

        </main>

        <!-- ########## END: MAIN PANEL ########## -->
      
    </div>
    @include('includes.footer')
    @include('includes.script')
    @include('includes.toastify')

  </body>
</html>
