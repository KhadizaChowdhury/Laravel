<section class="min-vh-75">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('../assets/img/curved-images/curved14.jpg');">
    <span class="mask bg-gradient-dark opacity-6"></span>
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Welcome!</h1>
            <p class="text-lead text-white">Use these awesome forms to login or create new account in your project for free.</p>
        </div>
        </div>
    </div>
    </div>
    <div class="container">
    <div class="row mt-lg-n10 mt-md-n11 mt-n10">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
        <div class="card z-index-0">
            <div class="card-header text-center pt-4">
            <h5>Enter 4 digit code here</h5>
            </div>
            <div class="card-body">
            <form role="form text-left">
                <div class="mb-3">
                  <input id="otp" name="otp" type="number" autocomplete="current-otp" required class="form-control" placeholder="otp" aria-label="otp" aria-describedby="otp-addon">
                </div>
                <div class="text-center">
                <button onclick="VerifyOtp()" type="button" class="btn bg-gradient-dark w-100 my-4 mb-2">Next</button>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>
    </div>
</section>

<script>
  async function VerifyOtp(){
    console.log("Clicked");
    let otp = document.getElementById('otp').value;
      if (otp.length!==4) {
        errorToast("Invalid OTP!")
      }
      else{
        showLoader();
        const response = await axios.post("/otp-verify",{
          email: sessionStorage.getItem('email'),
          otp: otp,
        });
        console.log(response);
        hideLoader();
        if(response.status===200 && response.data['status']==='success'){
          successToast(response.data['message'])
          sessionStorage.clear();
            setTimeout(() => {
              window.location.href = "{{url('/reset-password')}}";
            }, 1000);
        }
        else{
          errorToast("Failed")
          window.location.href = "{{url('/')}}";
        }
      }
  }

</script>