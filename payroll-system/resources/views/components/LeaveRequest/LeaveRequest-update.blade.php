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
                            <label class="form-label">LeaveRequest start_date *</label>
                            <input type="date" class="form-control" id="start_dateUpdate">
                        </div>
                        <div class="col-12 p-1">
                            <label class="form-label">LeaveRequest end_date *</label>
                            <input type="date" class="form-control" id="end_dateUpdate">
                        </div>
                        <div class="col-12 p-1">
                            <label class="form-label">Leave Category*</label>
                            <select id="leave_categoryUpdate" class="form-control">
                                <option value="1">Vacation</option>
                                <option value="2">Sick Leaves</option>
                                <option value="3">Unpaid Leaves</option>
                            </select>
                        </div>
                        <div class="col-12 p-1">
                            <label class="form-label">LeaveRequest status *</label>
                            <select id="statusUpdate" class="form-control" name="statusUpdate">
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                            </select>
                        </div>
                        <div class="col-12 p-1">
                            <label class="form-label">LeaveRequest reason *</label>
                            <input readonly id="reasonUpdate" type="text" class="form-control">
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
         console.log(id)
        let res=await axios.post("/leaveRequest-by-id",{id:id})
        hideLoader();
        document.getElementById('start_dateUpdate').value = res.data['start_date'];
        document.getElementById('end_dateUpdate').value = res.data['end_date'];
        document.getElementById('leave_categoryUpdate').value = res.data['leave_category_id'];
        document.getElementById('statusUpdate').value = res.data['status'];
        document.getElementById('reasonUpdate').value = res.data['reason'];
        console.log(res.data['reason'])
       
    }

    async function Update() {
        let start_date = document.getElementById('start_dateUpdate').value;
        let end_date = document.getElementById('end_dateUpdate').value;
        let leave_category = document.getElementById('leave_categoryUpdate').value;
        let status = document.getElementById('statusUpdate').value;
        let updateID = document.getElementById('updateID').value;

        if (start_date.length === 0) {
            errorToast("start_date Required !")
        }
        else if (end_date.length === 0) {
            errorToast("end_date Required !")
        }
        else if (status.length === 0) {
            errorToast("status Required !")
        }
        else{
            document.getElementById('update-modal-close').click();
            showLoader();
            let res = await axios.post("/update-leaveRequest",{
              start_date:start_date,
              end_date:end_date,
              leave_category_id:leave_category,
              status:status,
              id:updateID})
            hideLoader();
            console.log(res)
            if(res.status===200 && res.data.status=== 'Success'){
                document.getElementById("update-form").reset();
                successToast("Request success !")
                await getList();
            }
            else{
                 errorToast(res.data['message'])
            }


        }



    }



</script>
