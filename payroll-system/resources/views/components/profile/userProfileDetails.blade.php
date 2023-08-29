<div class="container-fluid">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-5 py-5">
            <div class="row justify-content-between ">
                <div class="align-items-center col">
                    <h4>User Profile Details</h4>
                </div>
            </div>
            <hr class="bg-dark "/>
            <table class="table">
                <thead>
                <tr class="bg-light">
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mobile</th>
                </tr>
                </thead>
                <tbody id="userDetails">
                  <tr>
                    <td>
                    <div class="flex items-center space-x-3">
                        <div>
                        <div id="firstName" class="font-bold"></div>
                        <div id="lastName" class="text-sm opacity-50">{{ $user->firstName }} {{ $user->lastName }}</div>
                        </div>
                    </div>
                    </td>
                    <td id="email">{{ $user->email }}</td>
                    <td id="mobile">{{ $user->mobile }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<script>
    window.onload = function()
    {
        getUser();
        async function getUser(){
            showLoader();
            const response = await axios.get("/user-profile")
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