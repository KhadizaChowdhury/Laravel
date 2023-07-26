<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
  <head>
    <!-- Required meta tags -->
    @include('includes.header')
    <!-- vendor css -->
    @include('includes.css')
    
  </head>
  <body class="h-full">

    <div class="min-h-full">
      @include('includes.navbar')

      <header class="bg-white shadow">
          <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
          <h1 class="text-3xl font-bold tracking-tight text-gray-900">Dashboard</h1>
          </div>
      </header>

      <!-- ########## START: MAIN PANEL ########## -->
        
        <main>

          <div id="loader" class="hidden w-full h-full fixed block top-0 left-0 bg-white opacity-75 z-50">

            <div class="mb-5 h-4 overflow-hidden rounded-full bg-gray-200">
              <div class="h-4 animate-pulse rounded-full bg-gradient-to-r from-green-500 to-blue-500" style="width: 100%"></div>
            </div>

          </div>

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
