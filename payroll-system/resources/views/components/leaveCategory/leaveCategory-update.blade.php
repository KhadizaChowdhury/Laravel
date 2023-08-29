<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">LeaveCategory name *</label>
                                <input readonly type="text" class="form-control" id="nameUpdate">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">LeaveCategory description *</label>
                                <input type="text" class="form-control" id="descriptionUpdate">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">LeaveCategory default_days *</label>
                                <input type="number" min="0" step="1" class="form-control" id="default_daysUpdate">
                            </div>
                            {{-- <div class="col-12 p-1">
                                <label class="form-label">LeaveCategory carry_over *</label>
                                <select id="carry_overUpdate" class="form-control" name="carry_over">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div> --}}
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
        let res=await axios.post("/leaveCategory-by-id",{id:id})
        // console.log(res)
        hideLoader();
        document.getElementById('nameUpdate').value = res.data['name'];
        document.getElementById('descriptionUpdate').value = res.data['description'];
        document.getElementById('default_daysUpdate').value = res.data['default_days'];
    }

    async function Update() {
        let description = document.getElementById('descriptionUpdate').value;
        let default_days = document.getElementById('default_daysUpdate').value;
        let updateID = document.getElementById('updateID').value;

        if (description.length === 0) {
            errorToast("description Required !")
        }
        else if (default_days.length === 0) {
            errorToast("default_days Required !")
        }
        else{
            document.getElementById('update-modal-close').click();
            showLoader();
            let res = await axios.post("/update-leaveCategory",{
              description:description,
              default_days:default_days,
              id:updateID})
            hideLoader();
            console.log(res)
            if(res.status===200 && res.data.status=== 'success'){
                document.getElementById("update-form").reset();
                successToast("Request success !")
                await getList();
            }
            else{
                errorToast("Request fail !")
            }


        }



    }



</script>
