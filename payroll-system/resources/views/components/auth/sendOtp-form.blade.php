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
            <h5>Your Email address</h5>
            </div>
            <div class="card-body">
            <form role="form text-left">
                <div class="mb-3">
                    <input id="email" name="email" type="email" autocomplete="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon">
                </div>
                <div class="text-center">
                <button onclick="SendOtp()" type="button" class="btn bg-gradient-dark w-100 my-4 mb-2">Next</button>
                </div>
                <p class="text-sm mt-3 mb-0">Already have an account? <a href="{{url('/user-login')}}" class="text-dark font-weight-bolder">Sign in</a></p>
            </form>
            </div>
        </div>
        </div>
    </div>
    </div>
</section>

<script>
  async function SendOtp(){
    console.log("Clicked");
    let email = document.getElementById('email').value;
      if (email.length===0) {
        errorToast("Please fill out email field")
      }
      else{
        showLoader();
        const response = await axios.post("/otp-send",{
          email: email,
        });
        console.log(email);

        if(response.status===200 && response.data['status']==='success'){
          successToast(response.data['message'])
          sessionStorage.setItem('email', email),
            setTimeout(() => {
                window.location.href = "{{url('/verify-otp')}}";
            }, 2000);
        }
        else{
          errorToast("Failed")
          window.location.href = "{{url('/')}}";
        }
        hideLoader();
      }
  }

</script>