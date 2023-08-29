<section class="min-vh-75">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('../assets/img/curved-images/curved14.jpg');">
    <span class="mask bg-gradient-dark opacity-6"></span>
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Welcome!</h1>
            <p class="text-lead text-white">Use this form to reset password.</p>
        </div>
        </div>
    </div>
    </div>
    <div class="container">
    <div class="row mt-lg-n10 mt-md-n11 mt-n10">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
        <div class="card z-index-0">
            <div class="card-header text-center pt-4">
            <h5>Reset password</h5>
            </div>
            <div class="row px-xl-5 px-sm-4 px-3">
            </div>
            <div class="card-body">
            <form role="form text-left">
                <div class="row mb-3">
                    <div class="col">
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                    </div>
                    <div class="col">
                        <input id="c_password" name="c_password" type="password" autocomplete="c-password" type="password" class="form-control" placeholder="Confirm Password" aria-label="c-password" aria-describedby="c-password-addon">
                    </div>
                </div>
                <div class="form-check form-check-info text-left">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                <label class="form-check-label" for="flexCheckDefault">
                    I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                </label>
                </div>
                <div class="text-center">
                <button onclick="ResetPass()" type="button" class="btn bg-gradient-dark w-100 my-4 mb-2">Reset password</button>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>
    </div>
</section>

<script>
    
        async function ResetPass(){
        console.log("Clicked");
        let password = document.getElementById('password').value;
        let c_password = document.getElementById('c_password').value;
        if (password.length===0) {
            errorToast("Please fill out password field")
        }
        else if (c_password.length===0) {
            errorToast("Please fill out confirm password field")
        }
        else if (password!=c_password) {
            errorToast("Password Doesn't match")
        }
        else{
            showLoader();
            const response = await axios.post("/password-reset",{
            password: password,
            });

            if(response.status===200 && response.data['status']==='success'){
              successToast(response.data['message'])
              setTimeout(() => {
                window.location.href = "{{url('/user-login')}}";
              }, 2000);
            }
            else{
            errorToast( response.data['message'])
            }
            hideLoader();
        }
    }

</script>