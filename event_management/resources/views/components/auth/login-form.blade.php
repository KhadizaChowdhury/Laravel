<div class="row">
  <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
    <div class="card card-plain mt-8">
      <div class="card-header pb-0 text-left bg-transparent">
        <h3 class="font-weight-bolder text-info text-gradient">Welcome back</h3>
        <p class="mb-0">Enter your email and password to sign in</p>
      </div>
      <div class="card-body">
        <form role="form">
          <label>Email</label>
          <div class="mb-3">
            <input id="email" type="email" autocomplete="email" required class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon">
          </div>
          <div class="flex items-center justify-between">
            <label>Password</label>
            <div class="text-sm">
              <a href="{{url('/send-otp')}}"  class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
            </div>
          </div>
          <div class="mb-3">
            <input id="password" type="password" autocomplete="current-password" required  class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
            <label class="form-check-label" for="rememberMe">Remember me</label>
          </div>
          <div class="text-center">
            <button onclick="SubmitLogIn()" type="button" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign in</button>
          </div>
        </form>
      </div>
      <div class="card-footer text-center pt-0 px-lg-2 px-1">
        <p class="mb-4 text-sm mx-auto">
          Don't have an account?
          <a href="{{url('/user-reg')}}" class="text-info text-gradient font-weight-bold">Sign up</a>
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
      <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('../assets/img/curved-images/curved6.jpg')"></div>
    </div>
  </div>
</div>

<script>
  async function SubmitLogIn(){
    console.log("Clicked");
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
      if (email.length===0) {
        errorToast("Please fill out email field")
      }
      else if (password.length===0) {
        errorToast("Please fill out password field")
      }
      else{
        showLoader();
        const response = await axios.post("/login-user",{
          email: email,
          password: password,
        });
        if(response.status===200 && response.data['status']==='success'){
            successToast(response.data['message'])
            console.log(email);
            console.log("success");
            window.location.href = "{{url('/dashboard')}}";
        }
        else{
            errorToast(response.data['message'])
            console.log("Error");
            setTimeout(() => {
                window.location.href = "{{url('/')}}";
            }, 2000);
        }
        hideLoader();
      }
  }

</script>