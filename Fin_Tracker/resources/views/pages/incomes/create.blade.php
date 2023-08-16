@extends('layouts.dashboard')
@section('dasboard-body-content')

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Add Income</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">

        <div class="border-b border-gray-900/10 pb-5">
            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                    <div class="mt-2">
                        <input id="description" type="text" name="first-name" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">Category</label>
                    <div class="mt-2">
                    <input id="category" type="text" name="last-name" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>



                <div class="sm:col-span-3">
                    <label for="amount" class="block text-sm font-medium leading-6 text-gray-900">Amount</label>
                    <div class="mt-2">
                    <input id="amount" type="text" name="amount" autocomplete="amount" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="date" class="block text-sm font-medium leading-6 text-gray-900">Date</label>
                    <div class="mt-2">
                        <input id="date" name="date" type="date" autocomplete="current-date" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

            </div>
        </div>

        <div>
            <button onclick="createIncome()" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add Income</button>
        </div>
  </div>
</div>

@endsection

<script>
    async function createIncome(event){
        event.preventDefault();
        console.log("Clicked");
        let description = document.getElementById('description').value;
        let category = document.getElementById('category').value;
        let amount = document.getElementById('amount').value;
        let date = document.getElementById('date').value;
        if (description.length===0) {
            errorToast("Please fill out description field")
        }
        else if (category.length===0) {
            errorToast("Please fill out category field")
        }
        else if (amount.length===0) {
            errorToast("Please fill out amount field")
        }
        else if (date.length===0) {
            errorToast("Please fill out date field")
        }
        else{
            showLoader();
            const response = await axios.post("/income",{
                category:category,
                description:description,
                amount: amount,
                date: date,
            });
            hideLoader();
            if(response.status===200 && response.data['status']==='success'){
                successToast(response.data['message'])
                document.getElementById('description').value = '';
                document.getElementById('category').value = '';
                document.getElementById('amount').value = '';
                document.getElementById('date').value = '';
            }
            else{
            errorToast( response.data['message'])
            }
        }
    }
</script>