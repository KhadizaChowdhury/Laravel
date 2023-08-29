<div class="container-fluid">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-5 py-5">
            <div class="row justify-content-between ">
                <div class="align-items-center col">
                    <h4>User Profiles</h4>
                </div>
            </div>
            <hr class="bg-dark "/>
            <table class="table" id="tableData">
                <thead>
                <tr class="bg-light">
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Details</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Edit</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Delete</th>
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
    let res=await axios.get("/list-user");
    hideLoader();
    // console.log(res)

    let tableList=$("#tableList");
    let tableData=$("#tableData");

    tableData.DataTable().destroy();
    tableList.empty();

    res.data.forEach(function (user,index) {
        let row=`<tr class="align-middle">
            <td>
                ${index+1}
            </td>
            <td>
            <p class="text-xs font-weight-bold mb-0"> ${user['firstName']} ${user['lastName']}</p>
            </td>
            <td>
            <span class="text-xs font-weight-bold mb-0"> ${user['email']}</span>
            </td>
            <td>
            <a href="/userProfile/${user['id']}" class="inline-block text-center">
                <span class="text-xs font-weight-bold mb-0">Details</span>
            </a>
            </td>
            <td class="align-middle">
                <button data-id="${user['id']}" class="btn editBtn btn-sm btn-outline-success">Edit</button>
            </td>
            <td class="align-middle">
                <button data-id="${user['id']}" class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>
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

