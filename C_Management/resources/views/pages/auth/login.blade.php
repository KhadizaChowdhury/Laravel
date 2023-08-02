@extends('layouts.app')
@section('body-content')

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
  </div>
  
  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <div>
        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
        <div class="mt-2">
          <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
          <div class="text-sm">
            <a href="{{url('/send-otp')}}"  class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
          </div>
        </div>
        <div class="mt-2">
          <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
      </div>

      <div>
        <button onclick="SubmitLogIn()" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
      </div>
  </div>
</div>

@endsection

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
            window.location.href = "{{url('/dashboard')}}";
        }
        else{
            errorToast(response.data['message'])
            setTimeout(() => {
                window.location.href = "{{url('/')}}";
            }, 2000);
        }
        hideLoader();
      }
  }

</script>