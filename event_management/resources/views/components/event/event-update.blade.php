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
                                <label class="form-label">Event title *</label>
                                <input type="text" class="form-control" id="titleUpdate">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Event description *</label>
                                <input type="text" class="form-control" id="descriptionUpdate">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Event location *</label>
                                <input type="text" class="form-control" id="locationUpdate">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Event time *</label>
                                <input type="time" class="form-control" id="timeUpdate">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Event date *</label>
                                <input type="date" class="form-control" id="dateUpdate">
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
        let res=await axios.post("/event-by-id",{id:id})
        hideLoader();
        document.getElementById('titleUpdate').value = res.data['title'];
        document.getElementById('descriptionUpdate').value = res.data['description'];
        document.getElementById('locationUpdate').value = res.data['location'];
        document.getElementById('timeUpdate').value = res.data['time'];
        document.getElementById('dateUpdate').value = res.data['date'];
    }

    async function Update() {

        let title = document.getElementById('titleUpdate').value;
        let description = document.getElementById('descriptionUpdate').value;
        let location = document.getElementById('locationUpdate').value;
        let time = document.getElementById('timeUpdate').value;
        let date = document.getElementById('dateUpdate').value;
        let updateID = document.getElementById('updateID').value;

        if (title.length === 0) {
            errorToast("title Required !")
        }
        else if (description.length === 0) {
            errorToast("description Required !")
        }
        else if (location.length === 0) {
            errorToast("location Required !")
        }
        else if (time.length === 0) {
            errorToast("time Required !")
        }
        else if (date.length === 0) {
            errorToast("date Required !")
        }
        else{
            document.getElementById('update-modal-close').click();
            showLoader();
            let res = await axios.post("/update-event",{
              title:title,
              description:description,
              location:location,
              time:time,
              date:date,
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
