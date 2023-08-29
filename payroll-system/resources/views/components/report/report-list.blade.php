<div class="container-fluid">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-5 py-5">
            <div class="row justify-content-between ">
                <div class="align-items-center col">
                    <h4>Select User</h4>
                </div>
            </div>
            <hr class="bg-dark "/>
            <table class="table" id="tableData">
                <thead>
                <tr class="bg-light">
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">start_date</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Leave Category</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">status</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Leave History</th>
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
    // console.log(res)

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

    res.data.forEach(function (report,index) {
        let categoryName = leaveCategoryMap[report['leave_category_id']] || 'Other';
        let row=`<tr class="align-middle">
            <td>
                ${index+1}
            </td>
            <td>
            <p class="text-xs font-weight-bold mb-0"> ${report['user']['firstName']} ${report['user']['lastName']}</p>
            </td>
            <td>
            <p class="text-xs font-weight-bold mb-0"> ${report['start_date']}</p>
            </td>
            <td>
            <p class="text-xs font-weight-bold mb-0"> ${categoryName}</p>
            </td>
            <td>
            <p class="text-xs font-weight-bold mb-0"> ${report['status']}</p>
            </td>
            <td class="align-middle">
                <button data-id="${report['user']['id']}" class="btn detailsBtn btn-sm btn-outline-success">LeaveHistory</button>
            </td>
        </tr>`

        tableList.append(row)
    })

    $('.detailsBtn').on('click', async function () {
           let id= $(this).data('id');
        //    alert(id)
           await FillUpUpdateForm(id)
           $("#details-modal").modal('show');
    })

    new DataTable('#tableData',{
        order:[[0,'desc']],
        lengthMenu:[5,10,15,20,30]
    });

}

</script>