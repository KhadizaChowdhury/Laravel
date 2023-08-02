@extends('layouts.app')
@section('body-content')

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Reset password</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <div class="sm:col-span-3">
        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
        <div class="mt-2">
            <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
      </div>

      <div class="sm:col-span-3">
        <label for="c_password" class="block text-sm font-medium leading-6 text-gray-900">Confirm Password</label>
        <div class="mt-2">
            <input id="c_password" name="c_password" type="password" autocomplete="re-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
      </div>

      <div>
        <button  onclick="ResetPass()" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Next</button>
      </div>

    <p class="mt-10 text-center text-sm text-gray-500">
      Not a member?
      <a href="/userLogin" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Start a 14 day free trial</a>
    </p>
  </div>
</div>

@endsection

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