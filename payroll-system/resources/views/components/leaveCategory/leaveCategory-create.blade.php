<div class="modal" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create LeaveCategory</h5>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">LeaveCategory name *</label>
                                <input type="text" class="form-control" id="categoryName">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">LeaveCategory description *</label>
                                <input type="text" class="form-control" id="description">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">LeaveCategory available_leaves *</label>
                                <input value="30" type="number" min="0" step="1" class="form-control" id="available_leaves">
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="Save()" id="save-btn" class="btn btn-sm  btn-success" >Save</button>
                </div>
            </div>
    </div>
</div>


<script>

    async function Save() {

        let categoryName = document.getElementById('categoryName').value;
        let description = document.getElementById('description').value;
        let available_leaves = document.getElementById('available_leaves').value;

        if (categoryName.length===0) {
            errorToast("Please fill out categoryName field")
        }
        else if (description.length===0) {
            errorToast("Please fill out description field")
        }
        else if (available_leaves.length===0) {
            errorToast("Please fill out available_leaves field")
        }
        else {

            document.getElementById('modal-close').click();

            showLoader();
            let response = await axios.post("/create-leaveCategory",{
                available_leaves:available_leaves,
                categoryName:categoryName,
                description:description,
                carry_over:0,
                max_carry_over_days:0
            })
            hideLoader();
            console.log(response)

            if(response.status===200 && response.data['status']==='success'){

                successToast('Request completed');

                document.getElementById("save-form").reset();

                await getList();
            }
            else{
                errorToast("Request fail !")
            }
        }
    }

</script>
