<!--   Core JS Files   -->
  <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>

<!-- toastify js -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script>
  function showLoader(){
    document.getElementById('loader').classList.remove('d-none')
  }

  function hideLoader(){
    document.getElementById('loader').classList.add('d-none')
  }
</script>
    