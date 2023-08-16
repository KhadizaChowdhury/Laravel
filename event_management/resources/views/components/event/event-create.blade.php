<div class="modal" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Event</h5>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Event title *</label>
                                <input type="text" class="form-control" id="title">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Event description *</label>
                                <input type="text" class="form-control" id="description">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Event location *</label>
                                <input type="text" class="form-control" id="location">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Event time *</label>
                                <input type="time" class="form-control" id="time">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Event date *</label>
                                <input type="date" class="form-control" id="date">
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

        let title = document.getElementById('title').value;
        let description = document.getElementById('description').value;
        let location = document.getElementById('location').value;
        let time = document.getElementById('time').value;
        let date = document.getElementById('date').value;

        if (title.length===0) {
            errorToast("Please fill out title field")
        }
        else if (description.length===0) {
            errorToast("Please fill out description field")
        }
        else if (location.length===0) {
            errorToast("Please fill out location field")
        }
        else if (time.length===0) {
            errorToast("Please fill out time field")
        }
        else if (date.length===0) {
            errorToast("Please fill out date field")
        }
        else {

            document.getElementById('modal-close').click();

            showLoader();
            let response = await axios.post("/create-event",{
                location:location,
                title:title,
                description:description,
                time: time,
                date: date,
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
