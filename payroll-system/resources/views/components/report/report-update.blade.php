<div class="modal" id="details-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">History</h5>
            </div>
            <div class="modal-body">
                <form id="details-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Total leaves taken</label>
                                <input readonly id="total" type="text" class="form-control">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Vacation leaves taken</label>
                                <input readonly id="vacation"type="text" class="form-control">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Unpaid leaves taken</label>
                                <input readonly readonly id="unpaid" type="text" class="form-control">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Sick leaves taken</label>
                                <input readonly id="sick" type="text" class="form-control" >
                            </div>
                            <input class="d-none" id="detailsID">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="details-modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                {{-- <button onclick="Update()" id="update-btn" class="btn btn-sm  btn-success" >Print</button> --}}
            </div>
        </div>
    </div>
</div>


<script>

   async function FillUpUpdateForm(id){
        document.getElementById('detailsID').value=id;
        showLoader();
        let res=await axios.post("/reports-by-userId",{id:id})
        hideLoader();
        
        let data = res['data'];
        let report = data['report'];
        let leaveRequest = data['leaveRequest'];
        console.log(report)
        document.getElementById('total').value = report['total_leaves_taken'];
        document.getElementById('vacation').value = report['vacation_leaves_taken'];
        document.getElementById('unpaid').value = report['unpaid_leaves_taken'];
        document.getElementById('sick').value = report['sick_leaves_taken'];
    }

</script>