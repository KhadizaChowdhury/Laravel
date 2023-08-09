@extends('layouts.dashboard')
@section('dasboard-body-content')
<div class="overflow-x-auto">
  <table class="table">
    <!-- head -->
    <thead>
      <tr>
        <th>
          <label>
            <input type="checkbox" class="checkbox" />
          </label>
        </th>
        <th>Name</th>
        <th>Email</th>
        <th>Mobile</th>
      </tr>
    </thead>
    <tbody id="userDetails">
      <!-- row-->
      <tr>
        <th>
        <label>
            <input type="checkbox" class="checkbox" />
        </label>
        </th>
        <td>
        <div class="flex items-center space-x-3">
            <div>
            <div id="firstName" class="font-bold"></div>
            <div id="lastName" class="text-sm opacity-50">{{ $user->lastName }}</div>
            </div>
        </div>
        </td>
        <td id="email">{{ $user->email }}</td>
        <td id="mobile">{{ $user->mobile }}</td>
    </tr>
    </tbody>
  </table>
</div>
@endsection

<script>
    window.onload = function()
    {
        getUser();
        async function getUser(){
            showLoader();
            const response = await axios.get("/user")
            hideLoader();
            if(response.status===200 && response.data['status']==='success'){
                let data = response.data['data'];
                document.getElementById('firstName').text = data['firstName'];
                document.getElementById('lastName').text = data['lastName'];
                document.getElementById('email').text = data['email'];
                document.getElementById('mobile').text = data['mobile'];

                successToast(response.data['message'])
            }
            else{
            errorToast( response.data['message'])
            } 
        }
    }
</script>