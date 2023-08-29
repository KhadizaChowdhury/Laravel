<div class="container-fluid">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-5 py-5">
            <div class="row justify-content-between ">
                <div class="align-items-center col">
                    <h4>LeaveRequest</h4>
                </div>
            </div>
            <hr class="bg-dark "/>
            <table class="table" id="tableData">
                <thead>
                <tr class="bg-light">
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SL</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employee Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">start_date</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Leave Category</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">status</th>
                    <th class="text-secondary opacity-7">Action</th>
                </tr>
                </thead>
                <tbody id="tableList">

                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<script>

getList();

async function getList() {


    showLoader();
    let res=await axios.get("/list-leaveRequest");
    hideLoader();
    console.log(res)

    let tableList=$("#tableList");
    let tableData=$("#tableData");

    tableData.DataTable().destroy();
    tableList.empty();

    const leaveCategoryMap = {
        1: 'Vacation',
        2: 'Sick Leave',
        3: 'Unpaid Leave',
        // ... other mappings
    };
    res.data.forEach(function (leaveRequest,index) {
        let categoryName = leaveCategoryMap[leaveRequest['leave_category_id']] || 'Other';

        let row=`<tr class="align-middle text-center">
            <td>
                ${index+1}
            </td>
            <td>
            <p class="text-xs font-weight-bold mb-0">${leaveRequest['user']['firstName']} ${leaveRequest['user']['lastName']}</p>
            </td>
            <td>
            <div class="d-flex px-2 py-1">
                <div class="d-flex flex-column justify-content-center">
                <p class="text-xs text-secondary mb-0"> ${leaveRequest['start_date']}</p>
                </div>
            </div>
            </td>
            <td>
            <span class="text-xs font-weight-bold mb-0">${categoryName}</span>
            </td>
            <td>
            <span class="text-xs font-weight-bold mb-0"> ${leaveRequest['status']}</span>
            </td>
            <td class="align-middle">
                <button data-id="${leaveRequest['id']}" class="btn editBtn btn-sm btn-outline-success">Edit</button>
                <button data-id="${leaveRequest['id']}" class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>
            </td>
        </tr>`

        tableList.append(row)
    })

    $('.editBtn').on('click', async function () {
           let id= $(this).data('id');
        //    alert(id)
           await FillUpUpdateForm(id)
           $("#update-modal").modal('show');
    })

    $('.deleteBtn').on('click',function () {
        let id= $(this).data('id');
        // alert(id)
        $("#delete-modal").modal('show');
        $("#deleteID").val(id);
    })

    new DataTable('#tableData',{
        order:[[0,'desc']],
        lengthMenu:[5,10,15,20,30]
    });

}

</script>

