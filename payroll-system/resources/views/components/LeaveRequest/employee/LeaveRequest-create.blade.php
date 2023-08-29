<section class="min-vh-75">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('../assets/img/curved-images/curved14.jpg');">
    <span class="mask bg-gradient-dark opacity-6"></span>
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Leave Request</h1>
        </div>
        </div>
    </div>
    </div>
    <div class="container">
    <div class="row mt-lg-n10 mt-md-n11 mt-n10">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
        <div class="card z-index-0">
            <div class="card-body">
            <form id="save-form">
                <div class="container">
                    <div class="row">
                        <div class="col-12 p-1">
                            <label class="form-label">LeaveRequest start_date *</label>
                            <input type="date" class="form-control" id="start_date">
                        </div>
                        <div class="col-12 p-1">
                            <label class="form-label">LeaveRequest end_date *</label>
                            <input type="date" class="form-control" id="end_date">
                        </div>
                        <div class="col-12 p-1">
                            <label class="form-label">Leave Category *</label>
                            <select id="leave_category_id" class="form-control" name="leave_category_id"></select>
                        </div>
                        <div class="col-12 p-1">
                            <label class="form-label">LeaveRequest Reason *</label>
                            <input type="text" class="form-control" id="reason">
                        </div>
                    </div>
                </div>
            </form>
            <div class="card-footer">
                <button onclick="Save()" id="save-btn" class="btn btn-sm  btn-success" >Request</button>
            </div>
        </div>
        </div>
    </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    async function fetchCategories() {
        try {
            // Make the API call using await
            const response = await axios.get('/get-leave-categories');
            const categories = response.data;

            const selectElement = document.getElementById('leave_category_id');

            // Clear existing options
            selectElement.innerHTML = '';

            // Populate the dropdown with the fetched categories
            categories.forEach(category => {
                const optionElement = document.createElement('option');
                optionElement.value = category.id;
                optionElement.textContent = category.categoryName;
                selectElement.appendChild(optionElement);
            });

        } catch (error) {
            console.error("Error fetching categories:", error);
        }
    }

    // Call the async function
    fetchCategories();
});

    
    async function Save() {

        let start_date = document.getElementById('start_date').value;
        let end_date = document.getElementById('end_date').value;
        let leave_category = document.getElementById('leave_category_id').value;
        let reason = document.getElementById('reason').value;
        console.log(reason)

        if (start_date.length===0) {
            errorToast("Please fill out start_date field")
        }
        else if (end_date.length===0) {
            errorToast("Please fill out end_date field")
        }
        else if (leave_category.length===0) {
            errorToast("Please fill out leave_category field")
        }
        else if (reason.length===0) {
            errorToast("Please fill out reason field")
        }
        else {

            showLoader();
            let response = await axios.post("/create-leaveRequest",{
                start_date:start_date,
                end_date:end_date,
                leave_category_id:leave_category,
                reason:reason,
            })
            hideLoader();
            console.log(response)

            if(response.data['status']==='success'){

                successToast('Request completed');

                document.getElementById("save-form").reset();
            }
            else{
                errorToast(response.data['message'])
            }
        }
    }
</script>
