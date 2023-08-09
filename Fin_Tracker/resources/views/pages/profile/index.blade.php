@extends('layouts.dashboard')
@section('dasboard-body-content')
<div class="container mx-auto">
    <div class="flex flex-col">
        <div class="w-full">
            <div class="p-8 border-b border-gray-200 shadow">
                <table class="divide-y divide-gray-300" id="tableData">
                    <thead class="bg-black">
                        <tr>
                            <th class="px-6 py-2 text-xs text-white">
                                ID
                            </th>
                            <th class="px-6 py-2 text-xs text-white">
                                Name
                            </th>
                            <th class="px-6 py-2 text-xs text-white">
                                Email
                            </th>
                            <th class="px-6 py-2 text-xs text-white">
                                Edit
                            </th>
                            <th class="px-6 py-2 text-xs text-white">
                                Delete
                            </th>
                        </tr>
                    </thead>
                    <tbody id="allUser" class="bg-white divide-y divide-gray-300">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    window.onload = function()
    {

    Users();
    async function Users() {
        let URL = "/allUser";
        try {
          const response = await axios.get(URL);
            const users = response.data;
            console.log(users);

            let tableData = $('#tableData');
            let allUser = $('#allUser');

            tableData.DataTable().destroy();
            allUser.empty();

            // Iterate over the users and create HTML elements for each user
            users.forEach(function(user,index){
              let row =
                `<tr class="text-center whitespace-nowrap">
                    <td class="px-6 py-4 text-sm text-gray-500">
                        ${index+1}
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">
                          ${user['firstName']} ${user['lastName']}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500">${user['email']}</div>
                    </td>
                    <td class="px-6 py-4">
                        <a href="/userProfile/${user['id']}" class="inline-block text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="inline-block text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </a>
                    </td>
                </tr>`

                

              allUser.append(row)
            });

            tableData.DataTable({
              order: [[3, 'desc']],
              lengthMenu: [3,5,10,15,20]
            })
        } catch (error) {
            console.error(error);
            // Handle the error, e.g., display an error message
        }
    }

    

    }

</script>