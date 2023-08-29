<div class="flex min-h-full flex-col justify-center px-6 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <h2 class="text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Update your Profile</h2>
  </div>

  <div class="sm:mx-auto sm:w-full sm:max-w-sm">

        <div class="border-b border-gray-900/10 pb-5">
            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">First name</label>
                    <div class="mt-2">
                        <input id="firstName" type="text" name="first-name" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">Last name</label>
                    <div class="mt-2">
                    <input id="lastName" type="text" name="last-name" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>



                <div class="sm:col-span-3">
                    <label for="mobile" class="block text-sm font-medium leading-6 text-gray-900">Mobile</label>
                    <div class="mt-2">
                    <input id="mobile" type="text" name="mobile" autocomplete="mobile" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="sm:col-span-4">
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input readonly id="email" name="email" type="email" autocomplete="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

            </div>
        </div>

        <div>
            <button onclick="UserUpdate()" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Update</button>
        </div>
  </div>
</div>

<script>
    getUser();
    async function getUser(){
        showLoader();
        const response = await axios.get("/user-profile")
        hideLoader();
        if(response.status===200 && response.data['status']==='success'){
            let data = response.data['data'];
            document.getElementById('firstName').value = data['firstName'];
            document.getElementById('lastName').value = data['lastName'];
            document.getElementById('email').value = data['email'];
            document.getElementById('mobile').value = data['mobile'];

            // successToast(response.data['message'])
        }
        else{
        errorToast( response.data['message'])
        } 
    }

    async function UserUpdate(){
        console.log("Clicked");
        let firstName = document.getElementById('firstName').value;
        let lastName = document.getElementById('lastName').value;
        let mobile = document.getElementById('mobile').value;
        if (firstName.length===0) {
            errorToast("Please fill out firstName field")
        }
        else if (lastName.length===0) {
            errorToast("Please fill out lastName field")
        }
        else if (mobile.length===0) {
            errorToast("Please fill out mobile field")
        }
        else{
            showLoader();
            const response = await axios.post("/updateProfile",{
                lastName:lastName,
                firstName:firstName,
                mobile: mobile,
            });
            hideLoader();
            if(response.status===200 && response.data['status']==='success'){
                successToast(response.data['message'])
                await getUser();
            }
            else{
            errorToast( response.data['message'])
            }
        }
    }
</script>