<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">First name</label>
                                <input id="firstNameUpdate" type="text" class="form-control">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Last name</label>
                                <input id="lastNameUpdate"type="text" class="form-control">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Email</label>
                                <input readonly id="emailUpdate" type="email" class="form-control">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Mobile</label>
                                <input id="mobileUpdate" type="number" class="form-control" >
                            </div>
                            <input class="d-none" id="updateID">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn btn-sm  btn-success" >Update</button>
            </div>
        </div>
    </div>
</div>


<script>

   async function FillUpUpdateForm(id){
        document.getElementById('updateID').value=id;
        showLoader();
        let res=await axios.post("/user-by-id",{id:id})
        hideLoader();
        console.log(res)
        let data = res['data'];
        document.getElementById('firstNameUpdate').value = data['firstName'];
        document.getElementById('lastNameUpdate').value = data['lastName'];
        document.getElementById('emailUpdate').value = data['email'];
        document.getElementById('mobileUpdate').value = data['mobile'];
    }

    async function Update() {
        let updateID = document.getElementById('updateID').value;
        let firstName = document.getElementById('firstNameUpdate').value;
        let lastName = document.getElementById('lastNameUpdate').value;
        let mobile = document.getElementById('mobileUpdate').value;

        if (firstName.length === 0) {
            errorToast("firstName Required !")
        }
        else if (lastName.length === 0) {
            errorToast("lastName Required !")
        }
        else if (mobile.length === 0) {
            errorToast("mobile Required !")
        }
        else{
            document.getElementById('update-modal-close').click();
            showLoader();
            let res = await axios.post("/update-profile",{
              firstName:firstName,
              lastName:lastName,
              mobile:mobile,
              id:updateID})
            hideLoader();
            console.log(res)
            if(res.status===200 && res.data.status=== 'success'){
                document.getElementById("update-form").reset();
                successToast("Request success !")
                await getList();
            }
            else{
                errorToast( res.data['message'])
            }
        }
    }

</script>
