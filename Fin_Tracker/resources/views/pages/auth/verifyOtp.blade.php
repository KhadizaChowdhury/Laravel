@extends('layouts.app')
@section('body-content')

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Enter Otp Code</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      
      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm font-medium leading-6 text-gray-900">4 digit code here</label>
        </div>
        <div class="mt-2">
          <input id="otp" name="otp" type="number" autocomplete="current-otp" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
      </div>

      <div>
        <button  onclick="VerifyOtp()" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Next</button>
      </div>
  </div>
</div>

@endsection


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